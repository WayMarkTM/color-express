<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 06.04.2017
 * Time: 2:02
 */

namespace app\components;

use app\services\AdvertisingConstructionReservationService;
use app\services\OrdersService;
use Yii;
use yii\base\Widget;
use app\services\UserService;

class BadgeWidget extends Widget
{
    public static $NEW_USER_COUNT = 1;
    public static $SHOPPING_CART_ITEMS_COUNT = 2;
    public static $CLIENTS_LIST_UNPROCCESSED_ORDERS_COUNT = 3;
    public static $CLIENTS_WITH_UNPROCESSED_ORDERS_COUNT = 4;
    public $param;
    public $paramId;

    public function run()
    {
        $count = 0;
        switch($this->param) {
            case self::$NEW_USER_COUNT:
                $count = UserService::getContNewClients();
                break;
            case self::$SHOPPING_CART_ITEMS_COUNT:
                $advertisingConstructionReservationService = new AdvertisingConstructionReservationService();
                $count = $advertisingConstructionReservationService->getCountShoppingCartItems();
                break;
            case self::$CLIENTS_LIST_UNPROCCESSED_ORDERS_COUNT:
                $ordersService = new OrdersService();
                $count = $ordersService->getUserUnprocessedOrdersQuery($this->paramId)->count();
                break;
            case self::$CLIENTS_WITH_UNPROCESSED_ORDERS_COUNT:
                $ordersService = new OrdersService();
                $count = $ordersService->getEmployeeUserWithUnproccessedOrdersQuery();
                break;
            default:
                $count = 0;
                break;
        }

        return $this->render('_badge', [
            'count' => $count,
        ]);
    }

}