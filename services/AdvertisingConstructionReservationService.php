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
        $reservations = $this->getShoppingCartItems()->all();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($reservations as $reservation) {
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
            ->where(['=', 'status_id', AdvertisingConstructionStatuses::IN_BASKET_ORDER]);
    }

    /**
     * @param mixed $model
     * @param integer $status
     * @return AdvertisingConstructionReservation
     */
    public function createReservation($model, $status) {
        $currentUserId = Yii::$app->user->getId();
        // TODO: add validation on busy construction
        $reservation = $this->getAdvertisingConstructionReservation($currentUserId, $model, $status);
        $reservation->save();

        return $reservation;
    }

    /**
     * @param integer $userId
     * @param mixed $model
     * @param integer $statusId
     * @return AdvertisingConstructionReservation
     */
    private function getAdvertisingConstructionReservation($userId, $model, $statusId) {
        $reservation = new AdvertisingConstructionReservation();
        $reservation->advertising_construction_id = intval($model['advertising_construction_id']);
        $reservation->marketing_type_id = intval($model['marketing_type']);
        $reservation->from = (new \DateTime($model['from']))->format('Y-m-d');
        $reservation->to = (new \DateTime($model['to']))->format('Y-m-d');
        $reservation->user_id = $userId;
        $reservation->status_id = $statusId;
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