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
use yii\data\ActiveDataProvider;
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

    public function actionDetails($clientId) {
        $clientService = new ClientsService();
        $orderService = new OrdersService();
        $user = $clientService->getClientDetails($clientId);
        $dataProvider = new ActiveDataProvider([
            'query' => $orderService->getOrders(),
            'sort' => [
                'attributes' => ['id'],
            ],
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('details', [
            'user' => $user,
            'ordersDataProvider' => $dataProvider
        ]);
    }

    public function actionDeclineOrder($clientId, $orderId) {
        $service = new OrdersService();
        $service->declineOrder($orderId);

        return $this->redirect('details?clientId='.$clientId);
    }

    public function actionApproveOrder($clientId, $orderId) {
        $service = new OrdersService();
        $service->approveOrder($orderId);

        return $this->redirect('details?clientId='.$clientId);
    }

}