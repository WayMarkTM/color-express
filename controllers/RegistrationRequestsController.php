<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 2:16 AM
 */

namespace app\controllers;


use app\services\RegistrationRequestsService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class RegistrationRequestsController extends Controller
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
        $service = new RegistrationRequestsService();

        $requests = $service->getRequests();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $requests,
            'sort' => [
                'attributes' => ['id', 'advertisingConstructionName', 'address', 'status', 'type', 'cost'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}