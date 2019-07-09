<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\entities\PortfolioItem;
use app\modules\admin\models\PortfolioItemForm;
use app\services\PortfolioService;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\BaseAdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PortfolioController implements the CRUD actions for PortfolioItem model.
 */
class PortfolioController extends BaseAdminController
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
     * Lists all PortfolioItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PortfolioItem::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PortfolioItem model.
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
     * Creates a new PortfolioItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PortfolioItemForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                $portfolioService = new PortfolioService();
                $entity = $portfolioService->savePortfolioItem($model);
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
     * Updates an existing PortfolioItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $portfolioService = new PortfolioService();
        if (Yii::$app->request->isPost) {
            $model = new PortfolioItemForm();
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile == null || $model->upload()) {
                $entity = $portfolioService->savePortfolioItem($model);
                return $this->redirect(['view', 'id' => $entity->id]);
            } else {
                return 'failed '.$model->imageFile;
            }
        }

        $entity = $this->findModel($id);
        $model = $portfolioService->getPortfolioItemForm($entity);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PortfolioItem model.
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
     * Finds the PortfolioItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PortfolioItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PortfolioItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
