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
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class AdvertisingConstructionController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new AdvertisingConstructionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->layout = 'base.php';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetails($id)
    {
        $model = $this->findModel($id);
        $reservationModel = new AdvertisingConstructionFastReservationForm();
        $reservationModel->fromDate = date("d.m.Y");
        $reservationModel->toDate = date("d.m.Y");

        return $this->render('view', [
            'model' => $model,
            'reservationModel' => $reservationModel
        ]);
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