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
use yii\helpers\ArrayHelper;
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
        $searchResults = $searchModel->searchItems(Yii::$app->request->queryParams, true, true);

        $sizes = AdvertisingConstructionService::getAdvertisingConstructionSizeDropdownItems();
        $types = AdvertisingConstructionService::getAdvertisingConstructionTypeDropdownItems();
        $addresses = ArrayHelper::map(AdvertisingConstruction::find()
            ->where(['=', 'type_id', $searchModel->type_id])
            ->andWhere(['=', 'is_published', '1'])
            ->select('address')
            ->all(), 'address', 'address');

        $this->layout = 'base.php';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'constructions' => $searchResults,
            'sizes' => $sizes,
            'types' => $types,
            'addresses' => $addresses,
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

    public function actionGetConstructionReservations($constructionId) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $bookings = $this->advertisingConstructionReservationService->getConstructionBookingsJson($constructionId);
        $reservations = $this->advertisingConstructionReservationService->getConstructionReservationsJson($constructionId);

        return [
            'reservations' => array_merge($bookings, $reservations)
        ];
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

    public function actionSummary() {
        $searchModel = new AdvertisingConstructionSearch();
        $searchResults = $searchModel->searchItems(Yii::$app->request->queryParams, true);
        $timelinesItems = $this->advertisingConstructionReservationService->getBookingsAndReservationForConstructions($searchResults);

        return $this->render('summary', [
            'timelinesItems' => $timelinesItems
        ]);
    }

    public function actionValidateConstructionDateRange() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Yii::$app->request->post();

        if (!$this->advertisingConstructionReservationService->isDateRangesValid($model)) {
            return [
                'isValid' => false,
                'message' => 'Данные даты заняты для бронирования.'
            ];
        }

        return [
            'isValid' => true
        ];
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