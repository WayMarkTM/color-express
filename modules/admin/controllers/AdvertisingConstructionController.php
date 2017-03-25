<?php

namespace app\modules\admin\controllers;

use app\models\entities\AdvertisingConstructionSize;
use app\modules\admin\models\AdvertisingConstructionForm;
use Yii;
use app\models\entities\AdvertisingConstruction;
use app\models\AdvertisingConstructionSearch;
use app\services\AdvertisingConstructionService;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AdvertisingConstructionController implements the CRUD actions for AdvertisingConstruction model.
 */
class AdvertisingConstructionController extends BaseAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdvertisingConstruction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertisingConstructionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdvertisingConstruction model.
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
     * Creates a new AdvertisingConstruction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new AdvertisingConstructionForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                $service = new AdvertisingConstructionService();
                $id = $service->saveAdvertisingConstruction($model);
                return $this->redirect(['view', 'id' => $id]);
            }

            throw new Exception('Something went wrong with image uploading');
        } else {
            $sizes = AdvertisingConstructionService::getAdvertisingConstructionSizeDropdownItems();
            $types = AdvertisingConstructionService::getAdvertisingConstructionTypeDropdownItems();
            return $this->render('create', [
                'model' => $model,
                'sizes' => $sizes,
                'types' => $types
            ]);
        }
    }

    /**
     * Updates an existing AdvertisingConstruction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $service = new AdvertisingConstructionService();
            $service->saveAdvertisingConstruction($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $sizes = AdvertisingConstructionService::getAdvertisingConstructionSizeDropdownItems();
            $types = AdvertisingConstructionService::getAdvertisingConstructionTypeDropdownItems();
            return $this->render('update', [
                'model' => $model,
                'sizes' => $sizes,
                'types' => $types
            ]);
        }
    }

    /**
     * Deletes an existing AdvertisingConstruction model.
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
