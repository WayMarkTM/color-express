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
        if ($userId == null) {
            $userId = Yii::$app->user->getId();
        }

        return $this->getUserOrdersQuery($userId);
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

        $reservation = AdvertisingConstructionReservation::findOne($id);
        $mailService = new MailService();
        $user = User::findIdentity($reservation->user_id);
        if($user && $reservation) {
            $mailService->approveOrDeclineOrder($user, $reservation, false);
        }
    }

    /**
     * @param integer $id
     * @param number $cost
     */
    public function approveOrder($id, $cost) {
        $reservation = AdvertisingConstructionReservation::findOne($id);

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
                $mailService->approveOrDeclineOrder($user, $reservation, true);
            }
        }
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
            ->andWhere(['in', 'status_id', [AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::RESERVED, AdvertisingConstructionStatuses::APPROVED, AdvertisingConstructionStatuses::DECLINED, AdvertisingConstructionStatuses::APPROVED_RESERVED]]);
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