<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:24
 */

namespace app\controllers;

use app\models\entities\AdvertisingConstructionReservation;
use app\models\SubmitCartForm;
use app\services\AdvertisingConstructionReservationService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ShoppingCartController extends Controller
{
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
        $submitCartModel = new SubmitCartForm();
        $service = new AdvertisingConstructionReservationService();

        if ($submitCartModel->load(Yii::$app->request->post()) && $submitCartModel->validate()) {
            if ($service->checkOutReservations($submitCartModel->thematic)) {
                Yii::$app->session->setFlash('checkOutCompleted');
            }
        }

        $cartTotal = $service->getCartTotal();

        $dataProvider = new ActiveDataProvider([
            'query' => $service->getShoppingCartItems(),
            'sort' => [
                'attributes' => ['id'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'submitCartModel' => $submitCartModel,
            'cartTotal' => $cartTotal
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = AdvertisingConstructionReservation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}