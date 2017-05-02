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
use app\services\ClientsService;
use app\services\DocumentService;
use app\services\SubclientService;
use app\services\UserService;
use app\services\OrdersService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
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

    public function init() {
        $this->documentService = new DocumentService();
        $this->subclientService = new SubclientService();
        $this->clientsService = new ClientsService();
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

        $employeeList = $service->getEmployeeList();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'employeeList' => $employeeList,
        ]);
    }

    public function actionDetails($clientId) {
        $orderService = new OrdersService();
        $user = $this->clientsService->getClientDetails($clientId);
        $dataProvider = new ActiveDataProvider([
            'query' => $orderService->getOrders($clientId),
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

    public function actionDetailsDocuments($clientId) {
        $subclients = array();
        $documentsCalendar = array();
        $user = $this->clientsService->getClientDetails($clientId);

        if ($user->is_agency) {
            $subclients = $this->subclientService->getSubclients($clientId);
        } else {
            $documentsCalendar = $this->documentService->getDocumentsCalendar($clientId);
        }

        return $this->render('detailsDocuments', [
            'user' => $user,
            'documentsCalendar' => $documentsCalendar,
            'subclients' => $subclients
        ]);
    }

    public function actionDelete($id)
    {
        //add user can delete
        $userService = new UserService();
        $userService->deleteClient($id);
        $this->redirect('index');
    }

    public function actionDocuments()
    {
        $currentUserId = Yii::$app->user->getId();
        $user = User::findOne($currentUserId);
        $subclients = array();
        $documentsCalendar = array();

        if ($user->is_agency) {
            $subclients = $this->subclientService->getSubclients($currentUserId);
        } else {
            $documentsCalendar = $this->documentService->getDocumentsCalendar($currentUserId);
        }

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
            $userService = new UserService();
            if($signupForm->getAttributes() !== Yii::$app->request->post() &
                $signupForm->load(Yii::$app->request->post())) {
                $userService->save($signupForm, $id);
            }
            if($signupForm->scenario = SignupForm::SCENARIO_EmployeeApplySignup) {
                $userService->setActiveUser($id);
            }
            $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('@app/views/layouts/_partial/_client_form', [
                'model' => $signupForm
            ]);
        }
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

    public function actionGetCurrentEmployeeClients() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $clients = $this->clientsService->getClients();

        return [
            'clients' => $clients
        ];
    }
}