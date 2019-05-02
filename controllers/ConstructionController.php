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
use app\models\entities\AdvertisingConstructionReservation;
use app\models\entities\AdvertisingConstructionType;
use app\models\InterruptionForm;
use app\services\AdvertisingConstructionReservationService;
use app\services\AdvertisingConstructionService;
use app\services\AdvertisiongConstructionNotificationService;
use app\services\UserService;
use app\services\SeoService;
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


class ConstructionController extends Controller
{
    /**
    * @var AdvertisingConstructionReservationService
    */
    private $advertisingConstructionReservationService;

    /**
     * @var UserService
     */
    private $userService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['buy-construction', 'summary', 'reserv-construction', 'buy-constructions', 'reserv-constructions'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['summary'],
                        'roles' => ['employee'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['buy-construction', 'reserv-construction', 'buy-constructions', 'reserv-constructions','notification-create'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init() {
        $this->advertisingConstructionReservationService = new AdvertisingConstructionReservationService();
        $this->userService = new UserService();
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

        $sizes = AdvertisingConstructionService::getAdvertisingConstructionSizeDropdownItems($searchModel->type_id);
        $types = AdvertisingConstructionService::getAdvertisingConstructionTypeDropdownItems();
        $constructionTypes = AdvertisingConstructionService::getAdvertisingConstructionTypes();

        $constructionType = AdvertisingConstructionType::findOne($searchModel->type_id);

        $this->layout = 'base.php';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'constructions' => $searchResults,
            'sizes' => $sizes,
            'types' => $types,
            'constructionTypes' => $constructionTypes,
            'constructionType' => $constructionType
        ]);
    }

    public function actionDetails($id)
    {
        $model = $this->findModel($id);

        SeoService::setMetaTags($model->meta_description, $model->meta_keywords);
        if ($model->meta_title != null && $model->meta_title != '') {
            $this->view->title = $model->meta_title;    
        }

        $reservationModel = new AdvertisingConstructionFastReservationForm();
        $reservationModel->fromDate = date("d.m.Y");
        $reservationModel->toDate = date("d.m.Y");

        $bookings = $this->advertisingConstructionReservationService->getConstructionBookings($id);
        $reservations = $this->advertisingConstructionReservationService->getConstructionReservations($id);

        $marketing_types = AdvertisingConstructionService::getMarketingTypeDropdownItems();

        $isNotificate = AdvertisiongConstructionNotificationService::getIsNotificate($id);

        return $this->render('view', [
            'model' => $model,
            'reservationModel' => $reservationModel,
            'bookings' => $bookings,
            'reservations' => $reservations,
            'marketingTypes' => $marketing_types,
            'isNotificate' => $isNotificate
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

        return new MethodNotAllowedHttpException();
    }

    public function actionBuyConstructions() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* ids, from, to */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            return $this->advertisingConstructionReservationService->createMultipleReservations($model, AdvertisingConstructionStatuses::IN_BASKET_ORDER);
        }

        return new MethodNotAllowedHttpException();
    }

    public function actionReservConstruction() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* id, from, to, user_id? */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            return $this->advertisingConstructionReservationService->createReservation($model, AdvertisingConstructionStatuses::IN_BASKET_RESERVED);
        }

        return new MethodNotAllowedHttpException();
    }

    public function actionReservConstructions() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* ids, from, to */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            return $this->advertisingConstructionReservationService->createMultipleReservations($model, AdvertisingConstructionStatuses::IN_BASKET_RESERVED);
        }

        return new MethodNotAllowedHttpException();
    }

    public function actionSummary() {
        $manager = Yii::$app->request->post('manager');
        $client = Yii::$app->request->post('client');
        $address = Yii::$app->request->post('address');

        $searchModel = new AdvertisingConstructionSearch();
        $searchResults = $searchModel->searchItems(Yii::$app->request->queryParams, true);
        $timelinesItems = $this->advertisingConstructionReservationService->getBookingsAndReservationForConstructions($searchResults, $address, $client, $manager);

        $managers = $this->userService->employeeDropDown();
        array_unshift($managers, 'Выберите менеджера');

        return $this->render('summary', [
            'timelinesItems' => $timelinesItems,
            'manager' => $manager,
            'client' => $client,
            'address' => $address,
            'managers' => $managers
        ]);
    }

    public function actionValidateAndSaveConstructionDateRange() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Yii::$app->request->post();

        if (!$this->advertisingConstructionReservationService->validateAndUpdateReservationRange($model)) {
            return [
                'isValid' => false,
                'message' => 'Данные даты заняты для бронирования.'
            ];
        }

        return [
            'isValid' => true
        ];
    }

    public function actionNotificationCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $constructionId = Yii::$app->request->post('construction_id');
            $notificationService = new AdvertisiongConstructionNotificationService();
            $notificationService->createNotification($constructionId);
            return ['isValid' => true];
        }
        return ['isValid' => false];
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

    public function actionInterruptValidation() {
        $interruptionForm = new InterruptionForm();
        if (Yii::$app->request->isAjax && $interruptionForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!ActiveForm::validate($interruptionForm)) {
                return false;
            }

            $reservation = AdvertisingConstructionReservation::findOne($interruptionForm->id);
            if (new \DateTime($reservation->from) > new \DateTime($interruptionForm->toDate) ||
                new \DateTime($reservation->to) < new \DateTime($interruptionForm->toDate)) {
                return false;
            }

            return true;
        }
    }
}