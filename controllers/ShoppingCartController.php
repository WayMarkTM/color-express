<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:24
 */

namespace app\controllers;

use app\models\entities\AdvertisingConstructionReservation;
use app\models\entities\MarketingType;
use app\models\SubmitCartForm;
use app\services\AdvertisingConstructionReservationService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ShoppingCartController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'checkout', 'delete'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'checkout', 'delete'],
                        'roles' => ['@'],
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

    /**
     * @var AdvertisingConstructionReservationService
     */
    private $advertisingConstructionReservationService;

    public function init() {
        $this->advertisingConstructionReservationService = new AdvertisingConstructionReservationService();
        parent::init();
    }

    public function actionIndex() {
        $marketingTypes = MarketingType::find()->all();

        return $this->render('index', [
            'cartItems' => $this->advertisingConstructionReservationService->getShoppingCartItems()->all(),
            'marketingTypes' => $marketingTypes
        ]);
    }

    public function actionCheckout() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Yii::$app->request->post();

        $result = $this->advertisingConstructionReservationService->checkOutReservations($model['thematic'], $model['reservations'], $model['comment']);

        return [
            'isValid' => count($result) == 0,
            'messages' => $result
        ];
    }

    public function actionDelete($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $this->findModel($id)->delete();

        return [
            'success' => true
        ];
    }

    protected function findModel($id)
    {
        if (($model = AdvertisingConstructionReservation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}