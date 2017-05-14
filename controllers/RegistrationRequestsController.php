<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 2:16 AM
 */

namespace app\controllers;


use app\services\UserService;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class RegistrationRequestsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'confirm-registration'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'confirm-registration'],
                        'roles' => ['employee'],
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
        $service = new UserService();

        $requests = $service->getNewClients();

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

    public function actionConfirmRegistration()
    {
        $id = \Yii::$app->request->get('id');
        if(!empty($id)) {
            $userService = new UserService();
            $userService->setActiveUser($id);
        }
        $this->redirect('index');
    }
}