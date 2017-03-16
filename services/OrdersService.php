<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:17 PM
 */

namespace app\services;

use app\models\OrderItemModel;

class OrdersService
{
    public function getOrders() {
        return array(
            $this->getOrder(1, 'РК_3х9_1551', 'ул. Лынькова 3', 'Настенный световой короб', 'Резерв до', new \DateTime('2016-01-11'), new \DateTime('2016-05-11'), 1000),
            $this->getOrder(2, 'РК_10x15_169', 'ул. Притыцкого 1', 'РК на путепроводе   ', 'Резерв до', new \DateTime('2016-01-01'), new \DateTime('2017-03-02'), 1000),
            $this->getOrder(3, 'РК_3х9_1220', 'ул. Сердича 22', 'РК в метро, переходе', 'Забронировано', new \DateTime('2016-10-11'), new \DateTime('2016-11-01'), 1500),
            $this->getOrder(4, 'РК_15х9_0054', 'ул. Машерова 18', 'Щитовая РК', 'Забпонировано', new \DateTime('2016-12-25'), new \DateTime('2017-02-20'), 700),
            $this->getOrder(5, 'РК_3х9_1551', 'ул. Плеханов 3', 'Брандмауэр', 'Завершено', new \DateTime('2016-12-13'), new \DateTime('2017-01-13'), 1500),
            $this->getOrder(6, 'РК_10х13_1001', 'ул. Якубова 48', 'Брандмауэр', 'Завершено', new \DateTime('2017-01-01'), new \DateTime('2017-02-28'), 1200),
        );
    }

    public function getOrdersByClient($id) {
        return $this->getOrders();
    }

    private function getOrder($id, $advertisingConstructionName, $address, $type, $status, $dateFrom, $dateTo, $cost) {
        $model = new OrderItemModel();

        $model->id = $id;
        $model->advertisingConstructionName = $advertisingConstructionName;
        $model->address = $address;
        $model->dateFrom = $dateFrom;
        $model->dateTo = $dateTo;
        $model->type = $type;
        $model->cost = $cost;
        $model->status = $status;


        return $model;
    }
}