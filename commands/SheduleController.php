<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 24.05.2017
 * Time: 1:48
 */

namespace app\commands;



use app\services\AdvertisingConstructionReservationService;
use app\services\AdvertisiongConstructionNotificationService;
use yii\console\Controller;

class SheduleController extends Controller
{
    public function actionNotificateFreeConstruction()
    {
        AdvertisiongConstructionNotificationService::checkNotifications();
    }

    public function actionNotifyEmployeeAfter1DayTheEndOfReservation()
    {
        $constuctionReservationService = new AdvertisingConstructionReservationService();
        $constuctionReservationService->notifyAfter1DayTheEndOfReservation();
        $constuctionReservationService->deleteOldReservation();
    }

    public function actionNotifyEmployeeBefore20DaysTheEndOfUse()
    {
        $constuctionReservationService = new AdvertisingConstructionReservationService();
        $constuctionReservationService->notifyEmployeeBefore20DaysTheEndOfUse();
    }

}