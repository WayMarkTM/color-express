<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/13/2017
 * Time: 12:05 AM
 */

namespace app\controllers;

use app\models\AdvertisingConstructionFastReservationForm;
use app\models\AdvertisingConstructionSearch;
use app\models\entities\AdvertisingConstruction;
use app\models\constants\AdvertisingConstructionStatuses;
use app\services\AdvertisingConstructionReservationService;
use app\services\AdvertisingConstructionService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\Request;


class ConstructionController extends Controller
{
    /**
    * @var AdvertisingConstructionReservationService
    */
    private $advertisingConstructionReservationService;

    public function init() {
        $this->advertisingConstructionReservationService = new AdvertisingConstructionReservationService();
        parent::init();
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

    public function actionIndex()
    {
        $searchModel = new AdvertisingConstructionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
        $sizes = AdvertisingConstructionService::getAdvertisingConstructionSizeDropdownItems();

        $this->layout = 'base.php';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sizes' => $sizes
        ]);
    }

    public function actionDetails($id)
    {
        $model = $this->findModel($id);
        $reservationModel = new AdvertisingConstructionFastReservationForm();
        $reservationModel->fromDate = date("d.m.Y");
        $reservationModel->toDate = date("d.m.Y");

        $bookings = $this->advertisingConstructionReservationService->getConstructionBookings($id);
        $reservations = $this->advertisingConstructionReservationService->getConstructionReservations($id);

        $marketing_types = AdvertisingConstructionService::getMarketingTypeDropdownItems();

        return $this->render('view', [
            'model' => $model,
            'reservationModel' => $reservationModel,
            'bookings' => $bookings,
            'reservations' => $reservations,
            'marketingTypes' => $marketing_types
        ]);
    }

    public function actionBuyConstruction() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* id, from, to, user_id? */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            return $this->advertisingConstructionReservationService->createReservation($model, AdvertisingConstructionStatuses::IN_BASKET_ORDER);
        }

        return [];
    }

    public function actionReservConstruction() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* id, from, to, user_id? */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            return $this->advertisingConstructionReservationService->createReservation($model, AdvertisingConstructionStatuses::IN_BASKET_RESERVED);
        }

        return [];
    }

    /**
     * Finds the AdvertisingConstruction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdvertisingConstruction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdvertisingConstruction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}