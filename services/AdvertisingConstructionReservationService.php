<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:42
 */

namespace app\services;

use app\models\constants\AdvertisingConstructionStatuses;
use app\models\constants\SystemConstants;
use app\models\entities\AdvertisingConstruction;
use app\models\entities\AdvertisingConstructionReservation;
use app\models\entities\AdvertisingConstructionReservationPeriod;
use app\models\entities\MarketingType;
use app\models\InterruptionForm;
use app\models\User;
use Yii;
use yii\helpers\Json;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\Query;
use yii\web\MethodNotAllowedHttpException;

class AdvertisingConstructionReservationService
{
    /**
     * @return Query Query List of Shopping Cart items.
     */
    public function getShoppingCartItems() {
        $current_user_id = Yii::$app->user->getId();

        $role = User::findIdentity($current_user_id)->getRole();
        if ($role != 'employee') {
            return $this->getReservationsQuery($current_user_id);
        } else {
            return $this->getEmployeeReservationsQuery($current_user_id);
        }
    }

    /**
     * @return number Total Shopping Cart cost
     */
    public function getCartTotal() {
        $current_user_id = Yii::$app->user->getId();

        return 0 + $this->getReservationsQuery($current_user_id)
            ->sum('cost');
    }

    /**
     * @param string $thematic
     * @param array $reservations
     * @param string $comment
     * @throws Exception
     * @return array|string Array of errors
     */
    public function checkOutReservations($thematic, $reservations, $comment) {
        $result = $this->validateFrontendReservations($reservations);

        if (count($result) == 0) {
            foreach ($reservations as $reservation) {
                $transaction = Yii::$app->db->beginTransaction();
                $res = $this->checkOutReservation($reservation, $thematic, $comment);
                if ($res != 'success') {
                    array_push($result, $res);
                    $transaction->rollBack();
                } else {
                    $transaction->commit();
                }
            }
        }

        return array_unique($result);
    }

    private function validateFrontendReservations($reservations) {
        $result = array();

        foreach ($reservations as $reservation1) {
            foreach ($reservations as $reservation2) {
                if ($reservation1['advertising_construction_id'] == $reservation2['advertising_construction_id'] && $reservation1['id'] != $reservation2['id']) {
                    if (DateService::intersects(new \DateTime($reservation1['from']), new \DateTime($reservation1['to']),
                        new \DateTime($reservation2['from']), new \DateTime($reservation2['to']))) {

                        array_push($result, 'Даты бронирований конструкций "'.$reservation1['name'] .'" и "'.$reservation2['name'].'" пересекаются.');
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param $reservation mixed
     * @param $thematic string
     * @param $comment string
     * @return bool True whether all reservations are checked out.
     */
    private function checkOutReservation($reservation, $thematic, $comment) {
        try {
            if ($this->isOnDismantling($model)) {
                $construction = AdvertisingConstruction::findOne($reservation['advertising_construction_id']);
                return 'Конструкция '.$construction->name.' ('.$construction->address.') будет на демонтаже c '.$construction->dismantling_from.' по '.$construction->dismantling_to;
            }

            if (!$this->isDateRangesValid($reservation)) {
                $construction = AdvertisingConstruction::findOne($reservation['advertising_construction_id']);
                return 'Конструкция '.$construction->name.' ('.$construction->address.') забронирована на даты c '.$reservation['from'].' по '.$reservation['to'];
            }

            $dbReservation = AdvertisingConstructionReservation::findOne($reservation['id']);
            $dbReservation->marketing_type_id = $reservation['marketing_type_id'];
            $dbReservation->from = $reservation['from'];
            $dbReservation->to = $reservation['to'];
            $dbReservation->thematic = $thematic;
            $dbReservation->comment = $comment;

            if (count($dbReservation->advertisingConstructionReservationPeriods) == 0) {
                $this->createReservationPeriods($reservation, $dbReservation);
                $dbReservation->cost = $this->getReservationCost($dbReservation->advertising_construction_id,
                    $dbReservation->marketing_type_id, $dbReservation->from, $dbReservation->to, $dbReservation->user_id);
            }

            if ($reservation['status_id'] == AdvertisingConstructionStatuses::IN_BASKET_RESERVED) {
                $dbReservation->status_id = AdvertisingConstructionStatuses::RESERVED;
            } else {
                $dbReservation->status_id =  AdvertisingConstructionStatuses::IN_PROCESSING;
            }

            if ($dbReservation->save() && Yii::$app->user->can('employee')) {
                $mailService = new MailService();
                $user = User::findIdentity($dbReservation->user_id);
                if ($user) {
                    $mailService->employeeRegisterForCompany($user, $dbReservation);
                }
            }

            return 'success';
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param mixed $reservation
     * @param AdvertisingConstructionReservation $dbReservation
     * 
     * @return AdvertisingConstructionReservationPeriod[]
     */
    private function createReservationPeriods($reservation, $dbReservation) {
        $periods = DateService::getMonthRanges($reservation['from'], $reservation['to']);
        $reservationPeriods = [];
        $price = $this->getReservationPrice($dbReservation->advertising_construction_id,
            $dbReservation->marketing_type_id, $dbReservation->user_id);
        
        foreach ($periods as $period) {
            $reservationPeriod = new AdvertisingConstructionReservationPeriod();
            $reservationPeriod->advertising_construction_reservation_id = $dbReservation->id;
            $reservationPeriod->from = $period['start'];
            $reservationPeriod->to = $period['end'];
            $reservationPeriod->price = $price;

            if (!$reservationPeriod->save()) {
                throw new Exception('Error during saving entity reservation period: '.Json::encode($reservationPeriod->getErrors()));
            }

            array_push($reservationPeriods, $reservationPeriod);
        }

        return $reservationPeriods;
    }

    /**
     * @param int $current_user_id
     *
     * @return Query
     */
    private function getReservationsQuery($current_user_id) {
        return AdvertisingConstructionReservation::find()
            ->where(['=', 'user_id', $current_user_id])
            ->andWhere(['in', 'status_id', [AdvertisingConstructionStatuses::IN_BASKET_ORDER, AdvertisingConstructionStatuses::IN_BASKET_RESERVED]]);
    }

    /**
     * @param integer $employeeId
     *
     * @return Query
     */
    private function getEmployeeReservationsQuery($employeeId) {
        return AdvertisingConstructionReservation::find()
            ->where(['=', 'employee_id', $employeeId])
            ->andWhere(['in', 'status_id', [AdvertisingConstructionStatuses::IN_BASKET_ORDER, AdvertisingConstructionStatuses::IN_BASKET_RESERVED]]);
    }

    /**
     * @param mixed $model
     * @param integer $status
     * @return mixed
     */
    public function createReservation($model, $status) {
        $userId = $model['user_id'];
        $managerId = $userId != null ? Yii::$app->user->getId() : null;
        if ($userId == null) {
            $userId = Yii::$app->user->getId();
        }

        if ($this->isOnDismantling($model)) {
            return [
                'isValid' => false,
                'message' => 'Данные даты попадают на даты демонтажа конструкции.'
            ];
        }

        if (!$this->isDateRangesValid($model)) {
            return [
                'isValid' => false,
                'message' => 'Данные даты заняты для бронирования.'
            ];
        }

        $reservation = $this->getAdvertisingConstructionReservation($userId, $model, $status, $managerId);
        $reservation->save();

        return [
            'isValid' => true,
            'reservation' => $reservation
        ];
    }

    public function createMultipleReservations($model, $status) {
        $userId = $model['user_id'];
        $managerId = $userId != null ? Yii::$app->user->getId() : null;
        if ($userId == null) {
            $userId = Yii::$app->user->getId();
        }

        foreach ($model['ids'] as $id) {
            $reservation = $this->getAdvertisingConstructionReservation($userId, [
                'from' => $model['from'] != null ? $model['from'] : (new \DateTime())->format('Y-m-d'),
                'to' => $model['to'] != null ? $model['to'] : (new \DateTime())->format('Y-m-d'),
                'advertising_construction_id' => $id
            ], $status, $managerId);

            $reservation->save();
        }

        return [
            'isValid' => true
        ];
    }

    /**
     * @param integer $id
     * @return array|AdvertisingConstructionReservation[]
     */
    public function getConstructionBookings($id) {
        return AdvertisingConstructionReservation::find()
            ->where(['=', 'advertising_construction_id', $id])
            ->andWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::APPROVED)])
            ->all();
    }

    /**
     * @param $id integer
     * @return array
     */
    public function getConstructionBookingsJson($id) {
        $bookings = $this->getConstructionBookings($id);
        $json = array();
        foreach ($bookings as $booking) {
            foreach ($booking->advertisingConstructionReservationPeriods as $period) {
                array_push($json, $this->getReservationJsonModel($reservationId, $period, 'booking'));
            }
        }

        return $json;
    }

    /**
     * @param integer $reservationId
     * @param AdvertisingConstructionReservationPeriod $reservationPeriod
     * @param string $type
     * @return array { id, from, to, type }
     */
    private function getReservationJsonModel($reservationId, $reservationPeriod, $type) {
        return [
            'id' => $reservationId,
            'from' => $reservationPeriod->from,
            'to' => $reservationPeriod->to,
            'type' => $type
        ];
    }

    /**
     * @param integer $id
     * @return array|AdvertisingConstructionReservation[]
     */
    public function getConstructionReservations($id) {
        return AdvertisingConstructionReservation::find()
            ->where(['=', 'advertising_construction_id', $id])
            ->andWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::RESERVED, AdvertisingConstructionStatuses::APPROVED_RESERVED)])
            ->all();
    }

    /**
     * @param $id integer
     * @return array
     */
    public function getConstructionReservationsJson($id) {
        $reservations = $this->getConstructionReservations($id);
        $json = array();
        foreach ($reservations as $reservation) {
            foreach ($reservation->advertisingConstructionReservationPeriods as $period) {
                array_push($json, $this->getReservationJsonModel($reservationId, $period, 'reservation'));
            }
        }

        return $json;
    }


    /**
     * @param array|AdvertisingConstruction[] $constructions
     * @param string $address
     * @param string $client
     * @param string $manager
     * @return array
     */
    public function getBookingsAndReservationForConstructions($constructions, $address, $client, $manager) {
        $result = array();
        foreach ($constructions as $construction) {
            if (!$this->isAddressFilterPassed($address, $construction)) {
                continue;
            }

            $bookings = $this->getConstructionBookings($construction->id);
            $bookingsResult = array();
            foreach($bookings as $booking) {
                if ($this->isClientAndManagerFilterPassed($client, $manager, $booking)) {
                    if ($this->isReservationContinuous($booking)) {
                        array_push($bookingsResult, $this->mapReservationForSummary($booking, null, 'booking'));
                    } else {
                        foreach ($booking->advertisingConstructionReservationPeriods as $reservationPeriod) {
                            array_push($bookingsResult, $this->mapReservationForSummary($booking, $reservationPeriod, 'booking'));
                        }
                    }
                }
            }

            $reservations = $this->getConstructionReservations($construction->id);
            $reservationsResult = array();
            foreach($reservations as $reservation) {
                if ($this->isClientAndManagerFilterPassed($client, $manager, $reservation)) {
                    if ($this->isReservationContinuous($reservation)) {
                        array_push($reservationsResult, $this->mapReservationForSummary($reservation, null, 'reservation'));
                    } else {
                        foreach ($reservation->advertisingConstructionReservationPeriods as $reservationPeriod) {
                            array_push($bookingsResult, $this->mapReservationForSummary($reservation, $reservationPeriod, 'reservation'));
                        }
                    }
                }
            }

            array_push($result, [
                'id' => $construction->id,
                'address' => $construction->address,
                'bookings' => $bookingsResult,
                'reservations' => $reservationsResult,
                'dismantling' => $construction->dismantling_from != null && $construction->dismantling_to ? [
                    'from' => $construction->dismantling_from,
                    'to' => $construction->dismantling_to,
                ] : null,
            ]);
        }

        usort($result, array($this, "addressCmp"));

        return $result;
    }

    /**
     * @param string $address
     * @param AdvertisingConstruction $construction
     * @return Boolean
     */
    private function isAddressFilterPassed($address, $construction) {
        return $address == null || $address == "" ||
            mb_stripos($construction->address, $address) !== false;
    }

    /**
     * @param string $client
     * @param string $manager
     * @param AdvertisingConstructionReservation $reservation
     * @return Boolean
     */
    private function isClientAndManagerFilterPassed($client, $manager, $reservation) {
        return ($client == null || $client == "" || ($reservation->user->company != null && mb_stripos($reservation->user->company, $client) !== false)) &&
            ($manager == null || $manager == "0" || ($reservation->user != null && $reservation->user->manage != null && $reservation->user->manage->id == $manager));
    }

    public function addressCmp($a, $b) {
        return strcmp($a['address'], $b['address']);
    }

    /**
     * @param AdvertisingConstructionReservation $reservation
     * @param AdvertisingConstructionReservationPeriod $reservationPeriod
     * @param string $type
     * @return array
     */
    private function mapReservationForSummary($reservation, $reservationPeriod, $type) {
        return [
            'id' => $reservation->id,
            'reservationPeriodId' => $reservationPeriod->id,
            'from' => $reservationPeriod != null ? $reservationPeriod->from : $reservation->from,
            'to' => $reservationPeriod != null ? $reservationPeriod->to : $reservation->to,
            'thematic' => $reservation->thematic,
            'comment' => $reservation->comment,
            'marketing_type' => $reservation->marketingType != null ? $reservation->marketingType->name : '',
            'manager' => $reservation->user != null && $reservation->user->manage != null ? $reservation->user->manage->name : '',
            'company' => $reservation->user != null ? $reservation->user->company : '',
            'type' => $type,
            'reserv_till' => $reservation->reserv_till
        ];
    }

    /**
     * @param mixed $model
     * @return Boolean is model valid
     */
    public function isOnDismantling($model) {
        $construction = AdvertisingConstruction::findOne($model['advertising_construction_id']);
        if ($construction->dismantling_from == null || $construction->dismantling_to == null) {
            return false;
        }

        return DateService::intersects(
            new \DateTime($model['from']),
            new \DateTime($model['to']),
            new \DateTime($construction->dismantling_from),
            new \DateTime($construction->dismantling_from)
        );
    }

    /**
     * @param mixed $model
     * @return Boolean is model valid
     */
    public function isDateRangesValid($model) {
        $reservationsQuery = AdvertisingConstructionReservation::find()
            ->where(['=', 'advertising_construction_id', $model['advertising_construction_id']])
            ->andFilterWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::RESERVED, AdvertisingConstructionStatuses::APPROVED_RESERVED , AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::APPROVED)]);
            
        if ($model['id']) {
            $reservationsQuery = $reservationsQuery
                ->andFilterWhere(['!=', 'id', $model['id']]);
        }
        
        $reservations = $reservationsQuery->all();

        foreach ($reservations as $reservation) {
            foreach ($reservation->advertisingConstructionReservationPeriods as $reservationPeriod) {
                if (DateService::intersects(new \DateTime($model['from']), new \DateTime($model['to']), new \DateTime($reservationPeriod->from), new \DateTime($reservationPeriod->to))) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return int Count of current user's shopping cart items.
     */
    public function getCountShoppingCartItems() {
        return $this->getShoppingCartItems()->count();
    }

    public function validateAndUpdateReservationRange($model) {
        if ($this->isOnDismantling($model)) {
            return false;
        }

        if (!$this->isDateRangesValid($model)) {
            return false;
        }

        $reservation = AdvertisingConstructionReservation::findOne($model['id']);
        $reservation->from = (new \DateTime($model['from']))->format('Y-m-d');
        $reservation->to = (new \DateTime($model['to']))->format('Y-m-d');
        $reservation->cost = $this->getReservationCost($reservation->advertising_construction_id,
            $reservation->marketing_type_id, $reservation->from, $reservation->to, $reservation->user_id);
        $reservation->save();

        return true;
    }
    /**
     * @param integer $userId
     * @param mixed $model
     * @param integer $statusId
     * @param integer|null $managerId
     * @return AdvertisingConstructionReservation
     */
    private function getAdvertisingConstructionReservation($userId, $model, $statusId, $managerId = null) {
        $reservation = new AdvertisingConstructionReservation();
        $reservation->advertising_construction_id = intval($model['advertising_construction_id']);
        $reservation->marketing_type_id = $model['marketing_type'] != null ? intval($model['marketing_type']) : null;
        $reservation->from = (new \DateTime($model['from']))->format('Y-m-d');
        $reservation->to = (new \DateTime($model['to']))->format('Y-m-d');
        $reservation->user_id = $userId;
        $reservation->status_id = $statusId;
        $reservation->employee_id = $managerId;
        $reservation->cost = $this->getReservationCost(intval($model['advertising_construction_id']),
            intval($model['marketing_type']), $reservation->from, $reservation->to, $reservation->user_id);

        if ($statusId == AdvertisingConstructionStatuses::IN_BASKET_RESERVED) {
            $reservation->reserv_till = date('Y-m-d', strtotime('today +5 weekdays'));
        }

        return $reservation;
    }

    /**
     * @param int $constructionId
     * @param int $marketingTypeId
     * @param string $from
     * @param string $to
     * @param int $user_id
     * @return float Cost
     */
    private function getReservationCost($constructionId, $marketingTypeId, $from, $to, $user_id) {
        $fromDate = new \DateTime($from);
        $toDate = new \DateTime($to);
        $days = intval($fromDate->diff($toDate)->days + 1);

        return $days * $this->getReservationPrice($constructionId, $marketingTypeId, $user_id);
    }

    /**
     * @param int $constructionId
     * @param int $marketingTypeId
     * @param int $user_id
     * @return float Price
     */
    public function getReservationPrice($constructionId, $marketingTypeId, $user_id) {
        $construction = AdvertisingConstruction::findOne($constructionId);
        $marketing_type_charge = $marketingTypeId != null ?
            MarketingType::findOne($marketingTypeId)->charge :
            0;
        $user = User::findOne($user_id);

        $agency_charge = $user->is_agency ? SystemConstants::AGENCY_PERCENT : 0;
        return $construction->price * (100 + $marketing_type_charge) / 100 * (100 - $agency_charge) / 100;
    }

    /**
     * @param integer $id
     * @throws MethodNotAllowedHttpException
     */
    public function buyReservedConstruction($id) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
        if ($reservation->status_id != AdvertisingConstructionStatuses::APPROVED_RESERVED) {
            throw new MethodNotAllowedHttpException();
        }

        $reservation->status_id = AdvertisingConstructionStatuses::IN_BASKET_ORDER;
        $reservation->save();
    }

    public function deleteOldReservation()
    {
        $reservations = AdvertisingConstructionReservation::find()
            ->where('reserv_till <= '. new Expression('CURDATE()'))
            ->andWhere('status_id = '.AdvertisingConstructionStatuses::RESERVED.' OR status_id = '.AdvertisingConstructionStatuses::APPROVED_RESERVED)
            ->all();

        echo 'Deleting '. count($reservations) .' old reservation... ';

        foreach ($reservations as $reservation) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                AdvertisingConstructionReservationPeriod::deleteAll('advertising_construction_reservation_id = '.$reservation->id);
                $reservation->delete();
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }

        echo 'Deleting old reservations is finished';
    }

    /**
     * @param $model InterruptionForm
     * @return bool
     */
    public function interruptReservation($model) {
        $reservation = AdvertisingConstructionReservation::findOne($model->id);
        if (new \DateTime($reservation->from) > new \DateTime($model->toDate) ||
            new \DateTime($reservation->to) < new \DateTime($model->toDate)) {
            return false;
        }

        $reservation->to = $model->toDate;
        $reservation->cost = $model->cost;
        $reservation->save();
        return true;
    }

    /**
     * @param AdvertisingConstructionReservation $reservation
     * @return bool
     */
    public function isReservationContinuous($reservation) {
        $firstPeriod = $reservation->advertisingConstructionReservationPeriods[0];
        $lastPeriod = $reservation->advertisingConstructionReservationPeriods[count($reservation->advertisingConstructionReservationPeriods) - 1];
        $borderTotalDays = (new \DateTime($lastPeriod->to))->diff(new \DateTime($firstPeriod->from))->days;
        $totalDays =  (new \DateTime($reservation->to))->diff(new \DateTime($reservation->from))->days;
        return $borderTotalDays == $totalDays;
    }

    public function notifyEmployeeBefore20DaysTheEndOfUse()
    {
        $reservations = AdvertisingConstructionReservation::find()
            ->where(['=', 'to', new Expression('CURDATE() + INTERVAL 20 DAY')])
            ->andWhere(['status_id' => AdvertisingConstructionStatuses::APPROVED])
            ->all();

        $mailService = new MailService();
        $usersReservations = $this->groupByUsersReservations($reservations);

        foreach($usersReservations as $reservationsByUser) {
            if ($mailService->sendNotifyEmployeeBefore20DaysTheEndOfUse($reservationsByUser)) {
                echo "Successfully send message about before 20 days the end of use to managers  \n";
            } else {
                echo "Error send message about before 20 days the end of use to managers \n";
            }
        }
    }

    public function notifyAfter1DayTheEndOfReservation()
    {
        $reservations = AdvertisingConstructionReservation::find()->where(
            ['<=', 'reserv_till', new Expression('CURDATE()')])
            ->andWhere([
                'OR',
                ['status_id' => AdvertisingConstructionStatuses::RESERVED],
                ['status_id' => AdvertisingConstructionStatuses::APPROVED_RESERVED]
            ])->all();
        $mailService = new MailService();
        $usersReservations = $this->groupByUsersReservations($reservations);

        foreach($usersReservations as $reservationsByUser) {
            if ($mailService->sendNotifyAfter1DayTheEndOfReservation($reservationsByUser)) {
                echo "Successfully send message about ended reservation after 1 day to managers and user  \n";
            } else {
                echo "Error send message about ended reservation after 1 day to managers and user \n";
            }
        }
    }

    private function groupByUsersReservations($reservations)
    {
        $usersReservations = [];
        foreach ($reservations as $reservation) {
            if (!$reservation->user || !$reservation->user->manage) {
                continue;
            }
            $userId = $reservation->user->id;

            if (!isset($usersReservations[$userId])) {
                $usersReservations[$userId] = [];
            }

            array_push($usersReservations[$userId], $reservation);
        }
        return $usersReservations;
    }
}