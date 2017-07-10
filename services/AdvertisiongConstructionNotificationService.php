<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 24.05.2017
 * Time: 5:58
 */

namespace app\services;

use app\models\constants\AdvertisingConstructionStatuses;
use app\models\entities\AdvertisingConstruction;
use Yii;
use app\models\entities\AdvertisingConstructionNotification;
use yii\db\Expression;

class AdvertisiongConstructionNotificationService
{
    public function createNotification($id)
    {
        $notification = new AdvertisingConstructionNotification();
        $notification->user_id = Yii::$app->user->getId();
        $notification->advertising_construction_id = $id;

        $notification->save();
    }

    public static function getIsNotificate($id)
    {
        $notification = AdvertisingConstructionNotification::find()->where([
            'user_id' => Yii::$app->user->getId(),
            'advertising_construction_id' => $id
        ])->count();

        return $notification > 0;

    }

    public static function checkNotifications()
    {
        $notifications = AdvertisingConstructionNotification::find()
            ->innerJoin(['construction' => 'advertising_construction_reservation'], 'construction.advertising_construction_id='.AdvertisingConstructionNotification::tableName().'.advertising_construction_id')
            ->where(['IN', 'construction.status_id', [AdvertisingConstructionStatuses::APPROVED, AdvertisingConstructionStatuses::APPROVED_RESERVED, AdvertisingConstructionStatuses::IN_PROCESSING]])
            ->andWhere(['<', 'construction.to', new Expression('CURDATE()')])
            ->all();

        $mailService = new MailService();
        foreach($notifications as $notificate) {
            /* @var $notificate AdvertisingConstructionNotification */
            $bcc = null;
            $manage = $notificate->user->manage;
            if ($manage != null) {
                $bcc = $manage->username;
            }

            if($mailService->sendNotificateAboutFreeConstruction($notificate->user->username, $notificate->advertising_construction_id, $bcc)) {
                $notificate->delete();
                echo "Sucessfull send message to user: $notificate->user->username \n";
            }
        }
        return $notifications;
    }
}