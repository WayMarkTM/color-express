<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 24.05.2017
 * Time: 5:58
 */

namespace app\services;

use Yii;
use app\models\entities\AdvertisingConstructionNotification;

class AdvertisiongConstructionNotificationService
{
    public function createNotification($id, $from, $to)
    {
        $notification = new AdvertisingConstructionNotification();
        $notification->user_id = Yii::$app->user->getId();
        $notification->advertising_construction_id = $id;
        $notification->from = $from;
        $notification->to = $to;

        $notification->save();
    }
}