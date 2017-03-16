<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 16.03.2017
 * Time: 19:24
 */

namespace app\controllers;

use app\models\SubmitCartForm;
use app\services\AdvertisingConstructionReservationService;
use Yii;
use yii\data\ArrayDataProvider;
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
        $service = new AdvertisingConstructionReservationService();
        $cartModel = $service->getShoppingCartItems();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $cartModel->cartItems,
            'sort' => [
                'attributes' => ['id', 'advertisingConstructionName', 'address', 'cost', 'marketingType'],
            ],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $submitCartModel = new SubmitCartForm();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'submitCartModel' => $submitCartModel,
            'cartTotal' => $cartModel->cartTotal
        ]);
    }
}