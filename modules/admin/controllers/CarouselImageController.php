<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\entities\CarouselImage;
use app\modules\admin\models\CarouselItemForm;
use app\services\CarouselService;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\BaseAdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CarouselImageController implements the CRUD actions for CarouselImage model.
 */
class CarouselImageController extends BaseAdminController
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
     * Lists all CarouselImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CarouselImage::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CarouselImage model.
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
     * Creates a new CarouselImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CarouselItemForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                $carouselService = new CarouselService();
                $entity = $carouselService->saveCarouselItem($model);
                return $this->redirect(['view', 'id' => $entity->id]);
            } else {
                return 'failed '.$model->imageFile;
            }
        }

        $model->isNewRecord = true;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CarouselImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $carouselService = new CarouselService();
        if (Yii::$app->request->isPost) {
            $model = new CarouselItemForm();
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile == null || $model->upload()) {
                $entity = $carouselService->saveCarouselItem($model);
                return $this->redirect(['view', 'id' => $entity->id]);
            } else {
                return 'failed '.$model->imageFile;
            }
        }

        $entity = $this->findModel($id);
        $model = $carouselService->getCarouselItemForm($entity);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CarouselImage model.
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
     * Finds the CarouselImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CarouselImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarouselImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
