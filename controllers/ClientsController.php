<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:55 PM
 */

namespace app\controllers;


use app\models\SignupForm;
use app\models\User;
use app\models\entities\AdvertisingConstructionReservationPeriod;
use app\services\AdvertisiongConstructionNotificationService;
use app\services\AdvertisingConstructionReservationPeriodService;
use app\services\ClientsService;
use app\services\DocumentService;
use app\services\SubclientService;
use app\services\UserService;
use app\services\OrdersService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

class ClientsController extends Controller
{
    /**
     * @var DocumentService
     */
    private $documentService;
    /**
     * @var SubclientService
     */
    private $subclientService;

    /**
     * @var ClientsService
     */
    private $clientsService;

    /**
     * @var OrdersService
     */
    private $ordersService;

    /**
     * @var AdvertisingConstructionReservationPeriodService
     */
    private $reservationPeriodService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'details', 'delete', 'update-manager', 'delete-order', 'decline-order', 'approve-order', 'details-documents', 'get-client-info', 'update-manager', 'get-current-employee-clients', 'document'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'details', 'delete', 'update-manager', 'delete-order', 'decline-order', 'approve-order', 'details-documents', 'get-client-info', 'update-manager', 'get-current-employee-clients'],
                        'roles' => ['employee'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['document', 'get-client-info'],
                        'roles' => ['client'],
                    ],
                ],
            ],
        ];
    }

    public function init() {
        $this->documentService = new DocumentService();
        $this->subclientService = new SubclientService();
        $this->clientsService = new ClientsService();
        $this->ordersService = new OrdersService();
        $this->reservationPeriodService = new AdvertisingConstructionReservationPeriodService();
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

    public function actionIndex() {
        $service = new UserService();

        $search = Yii::$app->request->post('search');
        $showAll = Yii::$app->request->get('show_all');

        $employeeId = null;
        if (!$showAll) {
            $employeeId = Yii::$app->user->getId();
        }
        $clients = $service->getClientsByEmployee($employeeId, $search);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $clients,
            'sort' => [
                'attributes' => ['id', 'company', 'name', 'phone', 'type', 'email']
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $tab = $showAll ? 'all-clients' : 'my-clients';

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'search' => $search,
            'tab' => $tab
        ]);
    }

    public function actionDetails($clientId) {
        $orderService = new OrdersService();
        $user = $this->clientsService->getClientDetails($clientId);
        $dataProvider = new ActiveDataProvider([
            'query' => $orderService->getOrders($clientId),
            'sort' => [
                'attributes' => ['id', 'advertisingConstructionName', 'address', 'status', 'type', 'cost'],
                'defaultOrder' => ['id' => SORT_DESC]
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

    public function actionRowDetails($id, $constructionId, $isEditable = false) {
        $periods = AdvertisingConstructionReservationPeriod::find()
            ->where(['=', 'advertising_construction_reservation_id', $id])
            ->orderBy('from ASC')
            ->all();

        $reservationDates = $this->reservationPeriodService->getConstructionReservationDates($constructionId);

        return $this->renderAjax('_rowDetails', [
            'periods' => $periods,
            'reservationDates' => $reservationDates,
            'id' => $id,
            'isEditable' => $isEditable,
        ]);
    }

    public function actionDetailsDocuments($clientId) {
        $user = $this->clientsService->getClientDetails($clientId);
        $subclients = $this->subclientService->getSubclients($clientId);
        $documentsCalendar = $this->documentService->getDocumentsCalendar($clientId);

        return $this->render('detailsDocuments', [
            'user' => $user,
            'documentsCalendar' => $documentsCalendar,
            'subclients' => $subclients,
        ]);
    }

    public function actionDelete($id)
    {
        //add user can delete
        $userService = new UserService();
        $userService->deleteClient($id);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDocuments()
    {
        $currentUserId = Yii::$app->user->getId();
        $user = User::findOne($currentUserId);
        $subclients = $this->subclientService->getSubclients($currentUserId);
        $documentsCalendar = $this->documentService->getDocumentsCalendar($currentUserId);
        AdvertisiongConstructionNotificationService::checkNotifications();

        return $this->render('documents', [
            'currentUser' => $user,
            'subclients' => $subclients,
            'documentsCalendar' => $documentsCalendar
        ]);
    }

    public function actionGetClientInfo($id, $scenario)
    {
        $userService = new UserService();
        $signupForm = new SignupForm();
        $signupForm->scenario = $scenario;
        $signupForm = $userService->setUserToSignUpForm($signupForm, $id);
        if (isset($_POST['SignupForm'])) {
            if($this->canEditUser($id)) {
                $userService = new UserService();
                if ($signupForm->getAttributes() !== Yii::$app->request->post() &&
                    $signupForm->load(Yii::$app->request->post())
                ) {
                    $userService->save($signupForm, $id);
                }
                if ($signupForm->scenario == SignupForm::SCENARIO_EmployeeApplySignup) {
                    $userService->setActiveUser($id);
                }
                $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $form = '@app/views/layouts/_partial/';
            if(Yii::$app->user->can('employee') && Yii::$app->user->getId() == $id ) {
                $form .= '_employee_form';
            }elseif (Yii::$app->user->can('employee') || (Yii::$app->user->can('client') && Yii::$app->user->getId() == $id)) {
                $form .= '_client_form';
            } else {
                return '';
            }
            return $this->renderAjax($form, [
                'model' => $signupForm
            ]);
        }
    }

    private function canEditUser($id)
    {
        $user = User::findIdentity($id);
        $access = false;
        if (Yii::$app->user->can('admin')) {
            $access = true;
        } elseif (Yii::$app->user->can('client') && !Yii::$app->user->can('admin') && Yii::$app->user->getId() == $id) {
            $access = true;
        } elseif (Yii::$app->user->can('employee') && $user->manage_id == Yii::$app->user->getId() || $user->manage_id == null) {
            $access = true;
        }

        return $access;
    }

    public function actionDeclineOrder($clientId, $orderId) {
        $service = new OrdersService();
        $service->declineOrder($orderId);

        return $this->redirect('details?clientId='.$clientId);
    }

    public function actionApproveOrder() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* id, userId, cost */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            $this->ordersService->approveOrder($model['id'], $model['cost']);
            return [
                'success' => true
            ];
        }

        return new MethodNotAllowedHttpException();
    }

    public function actionDeleteOrder() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* id */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            $this->ordersService->deleteOrder($model['id']);
            return [
                'success' => true
            ];
        }

        return new MethodNotAllowedHttpException();
    }

    public function actionGetCurrentEmployeeClients() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $manageId = Yii::$app->user->getId();
        $clients = $this->clientsService->getClients($manageId);

        return [
            'clients' => $clients
        ];
    }

    public function actionUpdateManager($id, $manager_id) {
        $userService = new UserService();
        $userService->updateManager($id, $manager_id);
        $this->redirect('index');
    }
}