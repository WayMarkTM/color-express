<?php
namespace app\controllers;

use app\models\entities\AdvertisingConstruction;
use app\models\constants\AdvertisingConstructionStatuses;
use app\models\constants\PageKey;
use app\models\entities\AdvertisingConstructionReservation;
use app\models\entities\AdvertisingConstructionType;
use app\services\AdvertisingConstructionReservationPeriodService;
use app\services\UserService;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\Request;
use yii\widgets\ActiveForm;

class ReservationPeriodController extends Controller
{
    /**
    * @var AdvertisingConstructionReservationPeriodService
    */
    private $advertisingConstructionReservationPeriodService;

    /**
     * @var UserService
     */
    private $userService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['save-periods', 'save-period'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['save-periods', 'save-period'],
                        'roles' => ['employee'],
                    ],
                ],
            ],
        ];
    }

    public function init() {
        $this->advertisingConstructionReservationPeriodService = new AdvertisingConstructionReservationPeriodService();
        $this->userService = new UserService();
        parent::init();
    }

    public function actionSavePeriod() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Yii::$app->request->post();

        if (!Yii::$app->request->isAjax) {
            return new MethodNotAllowedHttpException();
        }

        $reservationId = $model['reservationId'];
        // { id, price, from, to }
        $period = $model['period'];

        return $this->advertisingConstructionReservationPeriodService->savePeriod($reservationId, $period);
    }

    public function actionSavePeriods() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Yii::$app->request->post();

        if (!Yii::$app->request->isAjax) {
            return new MethodNotAllowedHttpException();
        }

        $reservationId = $model['reservationId'];
        // [ id, price, from, to ]
        $periods = $model['periods'];

        return $this->advertisingConstructionReservationPeriodService->savePeriods($reservationId, $periods);
    }
}
