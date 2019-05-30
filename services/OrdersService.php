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
     * @param number $cost
     */
    public function approveOrder($id, $cost) {
        $reservation = AdvertisingConstructionReservation::findOne($id);
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