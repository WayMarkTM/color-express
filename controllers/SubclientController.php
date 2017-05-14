<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 8:25 PM
 */

namespace app\controllers;

use app\models\AddSubclientForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SubclientController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create-validation'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create-validation'],
                        'roles' => ['employee'],
                    ],
                ],
            ],
        ];
    }
    public function actionCreateValidation() {
        $form = new AddSubclientForm();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
    }
}