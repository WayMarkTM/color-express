<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 20:56
 */

namespace app\controllers;


use app\models\User;
use app\models\entities\AdvertisingConstructionReservationPeriod;
use app\services\AdvertisingConstructionReservationService;
use app\services\OrdersService;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

class OrdersController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['client'],
                    ],
                ],
            ],
        ];
    }
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
        $service = new OrdersService();

        $dataProvider = new ActiveDataProvider([
            'query' => $service->getOrders(),
            'sort' => [
                'attributes' => ['id'],
            ],
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $isAgency = User::findIdentity(Yii::$app->user->getId())->is_agency;

        return $this->render('index', [
            'isAgency' => $isAgency,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRowDetails($id, $advanced = false) {
        $dataProvider = new ActiveDataProvider([
            'query' => AdvertisingConstructionReservationPeriod::find()
                ->where(['=', 'advertising_construction_reservation_id', $id])
        ]);

        return $this->renderAjax('_rowDetails', [
            'dataProvider' => $dataProvider,
            'advanced' => $advanced,
            'id' => $id,
        ]);
    }

    public function actionBuyReservedConstruction() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* id */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            $advertisingConstructionReservationService = new AdvertisingConstructionReservationService();
            try {
                $advertisingConstructionReservationService->buyReservedConstruction($model['id']);
            } catch (Exception $e) {
                return [
                    'isValid' => false
                ];
            }

            return [
                'isValid' => true
            ];
        }

        return new MethodNotAllowedHttpException();
    }

    public function actionUpdateThematic() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* id, thematic */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            $ordersService = new OrdersService();
            try {
                $ordersService->updateThematic($model['id'], $model['thematic']);
            } catch (Exception $e) {
                return [
                    'isValid' => false
                ];
            }

            return [
                'isValid' => true
            ]; 
        }

        return new MethodNotAllowedHttpException();
    }
}