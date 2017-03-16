<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:55 PM
 */

namespace app\controllers;


use app\services\ClientsService;
use app\services\OrdersService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class ClientsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex() {
        $service = new ClientsService();

        $clients = $service->getClients();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $clients,
            'sort' => [
                'attributes' => ['id', 'company', 'name', 'phone', 'type', 'email'],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetails($id) {
        $clientService = new ClientsService();
        $orderService = new OrdersService();
        $company = $clientService->getClientDetails($id);
        $orders = $orderService->getOrdersByClient($id);
        $ordersDataProvider = new ArrayDataProvider([
            'allModels' => $orders,
            'sort' => [
                'attributes' => ['id', 'advertisingConstructionName', 'address', 'status', 'type', 'cost']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $this->render('details', [
            'company' => $company,
            'ordersDataProvider' => $ordersDataProvider
        ]);
    }

}