<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 24.05.2017
 * Time: 1:48
 */

namespace app\commands;



use app\services\AdvertisingConstructionReservationService;
use yii\console\Controller;

class SheduleController extends Controller
{
    public function actionNotificationForTheDay()
    {
        $constuctionReservationService = new AdvertisingConstructionReservationService();
        $constuctionReservationService->notificateForTheDayReservation();
    }

}