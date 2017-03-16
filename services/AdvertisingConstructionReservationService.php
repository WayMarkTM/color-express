<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:42
 */

namespace app\services;

use app\models\ShoppingCartItem;
use app\models\ShoppingCartModel;

class AdvertisingConstructionReservationService
{
    public function getShoppingCartItems() {
        $model = new ShoppingCartModel();
        $model->cartItems = array(
            $this->getItem(1, 'РК_15х9_1558', 'Пр. Пушкина 58', new \DateTime('2016-01-11'), new \DateTime('2016-05-11'), 1000, 'Белорусская'),
            $this->getItem(2, 'РК_15х9_1558', 'Ул. Лынькова 33', new \DateTime('2016-01-01'), new \DateTime('2016-03-02'), 1000, 'Белорусская'),
            $this->getItem(3, 'РК_15х9_1558', 'Пр. Независимости 101', new \DateTime('2016-10-01'), new \DateTime('2016-11-01'), 1500, 'Иностранная'),
            $this->getItem(4, 'РК_15х9_1558', 'Ул. Харьковская 99', new \DateTime('2016-12-25'), new \DateTime('2017-02-20'), 2000, 'Иностранная'),
            $this->getItem(5, 'РК_15х9_1558', 'Пр. Пушкина 12', new \DateTime('2016-12-13'), new \DateTime('2017-01-13'), 1500, 'Белорусская'),
            $this->getItem(6, 'РК_15х9_1558', 'Ул. Ольшеского 123', new \DateTime('2017-01-01'), new \DateTime('2017-02-28'), 1700, 'Иностранная'),
            $this->getItem(7, 'РК_15х9_1558', 'Ул. Харьковская 12', new \DateTime('2017-01-01'), new \DateTime('2017-02-28'), 1500, 'Белорусская'),
        );
        $model->cartTotal = 10200;

        return $model;
    }

    // TODO: remove stub;
    private function getItem($id, $name, $address, $dateFrom, $dateTo, $cost, $marketingType) {
        $model = new ShoppingCartItem();
        $model->id = $id;
        $model->advertisingConstructionName = $name;
        $model->address = $address;
        $model->dateFrom = $dateFrom;
        $model->dateTo = $dateTo;
        $model->cost = $cost;
        $model->marketingType = $marketingType;

        return $model;
    }
}