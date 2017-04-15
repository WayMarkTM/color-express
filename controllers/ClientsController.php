<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:55 PM
 */

namespace app\controllers;


use app\services\ClientsService;
use app\services\UserService;
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
        $service = new UserService();

        $clients = $service->getEmployeeClient();

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
                'attributes' => ['id', 'advertisingConstructionName', 'address', 'status', 'type', 'cost']
            ],
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $this->render('details', [
            'user' => $user,
            'ordersDataProvider' => $dataProvider
        ]);
    }

    public function actionDelete($id)
    {
        //add user can delete
        $userService = new UserService();
        $userService->deleteClient($id);
        $this->redirect('index');
    }

}