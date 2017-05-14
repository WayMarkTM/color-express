<?php

namespace app\modules\admin\controllers;

use app\models\EmployeeModel;
use app\models\LoginForm;
use app\services\UserService;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use app\models\SignupForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return
        [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'delete', 'view', 'create', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'delete', 'view', 'create', 'delete'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionValidateLogin()
    {
        $authForm = new LoginForm();
        if (Yii::$app->request->isAjax && $authForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($authForm);
        }
    }

    public function actionValidateSignup()
    {
        $signupForm = new SignupForm();
        if (Yii::$app->request->isAjax && $signupForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($signupForm);
        }
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userService = new UserService();

        $employee = new SignupForm();
        $employee->setScenario(SignupForm::SCENARIO_CREATE_EMPLOYEE);

        if(Yii::$app->request->isPost) {
            if($employee->load(Yii::$app->request->post())) {
                $employee = $userService->save($employee);
                if($employee) {
                    $userRole = Yii::$app->authManager->getRole('employee');
                    Yii::$app->authManager->assign($userRole, $employee->getId());
                }

                $this->refresh();
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $userService->getEmployeeList(),
            'sort' => [
                'attributes' => ['name', 'surname', 'lastname', 'phone', 'username'],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'employee' => $employee,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'photo');
            $model->upload();
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /* @var $model User */
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'photo');
            $model->upload();
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
