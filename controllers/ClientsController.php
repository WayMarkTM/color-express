<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:55 PM
 */

namespace app\controllers;


use app\models\User;
use app\services\ClientsService;
use app\services\DocumentService;
use app\services\SubclientService;
use app\services\UserService;
use app\services\OrdersService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

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

    public function init() {
        $this->documentService = new DocumentService();
        $this->subclientService = new SubclientService();
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

    public function actionDetailsDocuments($clientId) {
        $subclients = array();
        $documentsCalendar = array();
        $clientService = new ClientsService();
        $user = $clientService->getClientDetails($clientId);

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

    public function actionDocuments() {
        $currentUserId = Yii::$app->user->getId();
        return $this->render('documents', [
            'currentUser' => User::findOne($currentUserId)
        ]);
    }

}