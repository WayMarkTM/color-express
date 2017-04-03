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
use Yii;
use yii\base\Exception;
use yii\db\Query;

class OrdersService
{

    /**
     * @return Query
     */
    public function getOrders() {
        $current_user_id = Yii::$app->user->getId();

        return $this->getUserOrdersQuery($current_user_id);
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
        $this->changeStatus($id, AdvertisingConstructionStatuses::DECLINED);
    }

    /**
     * @param integer $id
     */
    public function approveOrder($id) {
        $this->changeStatus($id, AdvertisingConstructionStatuses::APPROVED);
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
     * @return Query
     */
    private function getUserOrdersQuery($user_id) {
        return AdvertisingConstructionReservation::find()
            ->where(['=', 'user_id', $user_id])
            ->where('(status_id = '.AdvertisingConstructionStatuses::IN_PROCESSING.
                ' or status_id = '.AdvertisingConstructionStatuses::APPROVED.
                ' or status_id = '.AdvertisingConstructionStatuses::DECLINED.')');
    }

}