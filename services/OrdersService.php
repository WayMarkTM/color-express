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