<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:17 PM
 */

namespace app\services;

use app\models\constants\AdvertisingConstructionStatuses;
use app\models\entities\AdvertisingConstructionReservation;
use app\models\entities\AdvertisingConstructionReservationPeriod;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\db\Query;

class OrdersService
{

    /**
     * @param integer $userId
     * @return Query
     */
    public function getOrders($userId = null) {
        $isEmployeeList = true;
        if ($userId == null) {
            $userId = Yii::$app->user->getId();
            $isEmployeeList = false;
        }

        return $this->getUserOrdersQuery($userId, $isEmployeeList);
    }

    /**
     * @param integer $id
     */
    public function cancelOrder($id) {
        $this->changeStatus($id, AdvertisingConstructionStatuses::CANCELLED);
    }

    /**
     * @param integer $id
     */
    public function declineOrder($id) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
        $prev_status_id = $reservation->status_id;

        $this->changeStatus($id, AdvertisingConstructionStatuses::DECLINED);

        $mailService = new MailService();
        $user = User::findIdentity($reservation->user_id);
        if($user && $reservation) {
            $mailService->approveOrDeclineOrder($user, $reservation, $prev_status_id, false);
        }
    }

    /**
     * @param integer $id
     * @param string $thematic
     */
    public function updateThematic($id, $thematic) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
        $reservation->thematic = $thematic;
        $reservation->save();
    }

    /**
     * @param integer $id
     */
    public function deleteOrder($id) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
        foreach ($reservation->advertisingConstructionReservationPeriods as $period) {
            $period->delete();
        }
        
        $reservation->delete();
    }

    /**
     * @param integer $id
     * @param number $price
     */
    public function saveReservationPrice($id, $price) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
        $interval = DateService::calculateIntervalLength($reservation->from, $reservation->to);
        $reservation->cost = $price * $interval;
        $reservation->advertisingConstructionReservationPeriods[0]->price = $price;
        $reservation->advertisingConstructionReservationPeriods[0]->save();
        $reservation->save();
        return [
            'success' => true,
        ];
    }

    /**
     * @param integer $id
     * @param date $from
     * @param date $to
     */
    public function saveReservationDates($id, $from, $to) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
        $needReload = false;

        if ($from != null && $to != null) {
            $reservationService = new AdvertisingConstructionReservationService();
            $validationModel = [
                'id' => $id,
                'advertising_construction_id' => $reservation->advertising_construction_id,
                'from' => $from,
                'to' => $to,
            ];

            if (!$reservationService->isDateRangesValid($validationModel)) {
                return [
                    'success' => false,
                    'message' => 'Конструкция забронирована на даты с '.$from.' по '.$to,
                ];
            }

            if ($reservationService->isOnDismantling($validationModel)) {
                return [
                    'success' => false,
                    'message' => 'В заданный период конструкция на демонтаже',
                ];
            }

            $price = $reservation->cost / DateService::calculateIntervalLength($reservation->from, $reservation->to);
            $reservation->from = $from;
            $reservation->to = $to;
            $reservation->cost = $price * DateService::calculateIntervalLength($reservation->from, $reservation->to);

            $periods = DateService::getMonthRanges($from, $to);
            if (count($periods) == 1) {
                $reservation->advertisingConstructionReservationPeriods[0]->from = $from;
                $reservation->advertisingConstructionReservationPeriods[0]->to = $to;
                $reservation->advertisingConstructionReservationPeriods[0]->price = $price;
                $reservation->advertisingConstructionReservationPeriods[0]->save();
            } else {
                $needReload = true;
                $reservation->advertisingConstructionReservationPeriods[0]->delete();
                foreach ($periods as $period) {
                    $reservationPeriod = new AdvertisingConstructionReservationPeriod();
                    $reservationPeriod->advertising_construction_reservation_id = $reservation->id;
                    $reservationPeriod->from = $period['start'];
                    $reservationPeriod->to = $period['end'];
                    $reservationPeriod->price = $price;
        
                    if (!$reservationPeriod->save()) {
                        throw new Exception('Error during saving entity reservation period: '.Json::encode($reservationPeriod->getErrors()));
                    }
        
                    $reservationPeriod->save();
                }
            }

            $reservation->save();
        }
        
        return [
            'success' => true,
            'needReload' => $needReload,
        ];
    }

    /**
     * @param integer $id
     * @param number $cost
     * @param date $from
     * @param date $to
     */
    public function approveOrder($id, $cost, $from, $to) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
        if ($from != null && $to != null) {
            $reservationService = new AdvertisingConstructionReservationService();
            $validationModel = [
                'id' => $id,
                'advertising_construction_id' => $reservation->advertising_construction_id,
                'from' => $from,
                'to' => $to,
            ];

            if (!$reservationService->isDateRangesValid($validationModel)) {
                return [
                    'success' => false,
                    'message' => 'Конструкция забронирована на даты с '.$from.' по '.$to,
                ];
            }

            if ($reservationService->isOnDismantling($validationModel)) {
                return [
                    'success' => false,
                    'message' => 'В заданный период конструкция на демонтаже',
                ];
            }

            $reservation->from = $from;
            $reservation->to = $to;

            $reservation->advertisingConstructionReservationPeriods[0]->from = $from;
            $reservation->advertisingConstructionReservationPeriods[0]->to = $to;
            $reservation->advertisingConstructionReservationPeriods[0]->price = $cost/DateService::calculateIntervalLength($from, $to) ;
            $reservation->advertisingConstructionReservationPeriods[0]->save();
        }

        $prev_status_id = $reservation->status_id;

        if ($reservation->status_id == AdvertisingConstructionStatuses::IN_PROCESSING) {
            $reservation->status_id = AdvertisingConstructionStatuses::APPROVED;
        }

        if ($reservation->status_id == AdvertisingConstructionStatuses::RESERVED) {
            $reservation->status_id = AdvertisingConstructionStatuses::APPROVED_RESERVED;
        }

        $reservation->cost = $cost;
        if ($reservation->save()) {
            $mailService = new MailService();
            $user = User::findIdentity($reservation->user_id);
            if($user && $reservation) {
                $mailService->approveOrDeclineOrder($user, $reservation, $prev_status_id, true);
            }
        }

        return [
            'success' => true
        ];
    }

    public function buyReservation($reservationId) {
        $reservation = AdvertisingConstructionReservation::findOne($reservationId);
        $reservation->status_id = AdvertisingConstructionStatuses::IN_BASKET_ORDER;
        $reservation->employee_id = Yii::$app->user->getId();
        $reservation->save();
    }

    /**
     * @param integer $id
     * @param integer $status
     */
    private function changeStatus($id, $status) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
        $reservation->status_id = $status;
        $reservation->save();
    }

    /**
     * @param integer $clientId
     * @return Query
     */
    public function getOrdersByClient($clientId) {
        return $this->getUserOrdersQuery($clientId);
    }

    /**
     * @param integer $user_id
     * @param boolean $isEmployeeList
     * @return Query
     */
    private function getUserOrdersQuery($user_id, $isEmployeeList) {
        $statuses = [AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::RESERVED,
            AdvertisingConstructionStatuses::APPROVED, AdvertisingConstructionStatuses::APPROVED_RESERVED];

        if (!$isEmployeeList) {
            array_push($statuses, AdvertisingConstructionStatuses::DECLINED);
        }

        return AdvertisingConstructionReservation::find()
            ->where(['=', 'user_id', $user_id])
            ->andWhere(['in', 'status_id', $statuses])
            ->orderBy('`status_id` = 31 desc, `status_id` = 20 desc, `status_id` = 41 desc, (`status_id` = 40 and `to` > CURDATE()) desc');
    }

    /**
     * @param integer $user_id
     * @return Query
     */
    public function getUserUnprocessedOrdersQuery($user_id) {
        return AdvertisingConstructionReservation::find()
            ->where(['=', 'user_id', $user_id])
            ->andWhere(['in', 'status_id', [AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::RESERVED]]);
    }

    /**
     * @return integer int
     */
    public function getEmployeeUserWithUnproccessedOrdersQuery() {
        $manageId = Yii::$app->user->getId();
        $users = User::find()->where(['=', 'manage_id', $manageId])->all();
        $count = 0;
        foreach ($users as $user) {
            if ($this->getUserUnprocessedOrdersQuery($user->id)->count() > 0) {
                $count++;
            }
        }

        return $count;
    }
}