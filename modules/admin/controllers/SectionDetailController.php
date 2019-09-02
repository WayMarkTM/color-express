<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\entities\SectionDetail;
use app\modules\admin\models\SectionDetailForm;
use app\modules\admin\models\SectionDetailSearch;
use app\modules\admin\controllers\BaseAdminController;
use app\services\SectionDetailService;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SectionDetailController implements the CRUD actions for SectionDetail model.
 */
class SectionDetailController extends BaseAdminController
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
     * Lists all SectionDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SectionDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SectionDetail model.
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
     * Creates a new SectionDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SectionDetailForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                $sectionDetailService = new SectionDetailService();
                $entity = $sectionDetailService->saveItem($model);
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
     * Updates an existing SectionDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $sectionDetailService = new SectionDetailService();
        if (Yii::$app->request->isPost) {
            $model = new SectionDetailForm();
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile == null || $model->upload()) {
                $entity = $sectionDetailService->saveItem($model, $id);
                return $this->redirect(['view', 'id' => $entity->id]);
            } else {
                return 'failed '.$model->imageFile;
            }
        }

        $entity = $this->findModel($id);
        $model = $sectionDetailService->getForm($entity);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SectionDetail model.
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
     * Finds the SectionDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SectionDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SectionDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
