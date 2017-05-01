<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:42
 */

namespace app\services;

use app\models\constants\AdvertisingConstructionStatuses;
use app\models\entities\AdvertisingConstruction;
use app\models\entities\AdvertisingConstructionReservation;
use app\models\entities\MarketingType;
use Yii;
use yii\db\Exception;
use yii\db\Query;

class AdvertisingConstructionReservationService
{
    /**
     * @return Query Query List of Shopping Cart items.
     */
    public function getShoppingCartItems() {
        $current_user_id = Yii::$app->user->getId();

        return $this->getReservationsQuery($current_user_id);
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
     * @throws Exception
     * @return Boolean
     */
    public function checkOutReservations($thematic) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($this->getShoppingCartItems()->each() as $reservation) {
                $reservation->thematic = $thematic;
                $reservation->status_id = AdvertisingConstructionStatuses::IN_PROCESSING;
                $reservation->save();
            }

            $transaction->commit();
        } catch (Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }

        return true;
    }

    /**
     * @param int $current_user_id
     *
     * @return Query
     */
    private function getReservationsQuery($current_user_id) {
        return AdvertisingConstructionReservation::find()
            ->where(['=', 'user_id', $current_user_id])
            ->andWhere(['=', 'status_id', AdvertisingConstructionStatuses::IN_BASKET_ORDER]);
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

        // TODO: add validation on busy construction
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
     * @param integer $id
     * @return array|AdvertisingConstructionReservation[]
     */
    public function getConstructionReservations($id) {
        return AdvertisingConstructionReservation::find()
            ->where(['=', 'advertising_construction_id', $id])
            ->andWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::RESERVED)])
            ->all();
    }

    /**
     * @param mixed $model
     * @return Boolean is model valid
     */
    function isDateRangesValid($model) {
        $reservations = AdvertisingConstructionReservation::find()
            ->where(['=', 'advertising_construction_id', $model['advertising_construction_id']])
            ->andFilterWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::RESERVED, AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::APPROVED)])
            ->all();

        $dateService = new DateService();
        foreach ($reservations as $reservation) {
            if ($dateService->intersects(new \DateTime($model['from']), new \DateTime($model['to']), new \DateTime($reservation->from), new \DateTime($reservation->to))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param integer $userId
     * @param mixed $model
     * @param integer $statusId
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
        // TODO: add specific calculation for Agency
        $reservation->cost = $this->getReservationCost(intval($model['advertising_construction_id']), intval($model['marketing_type']));

        return $reservation;
    }

    /**
     * @param int $constructionId
     * @param int $marketingTypeId
     * @return float Cost
     */
    private function getReservationCost($constructionId, $marketingTypeId) {
        $construction = AdvertisingConstruction::findOne($constructionId);
        $marketing_type = MarketingType::findOne($marketingTypeId);

        return $construction->price * (100 + $marketing_type->charge) / 100;
    }
}