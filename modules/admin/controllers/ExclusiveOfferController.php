<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\entities\ExclusiveOfferPage;
use app\services\ExclusiveOfferService;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\BaseAdminController;
use app\modules\admin\models\ExclusiveOfferForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ExclusiveOfferController implements the CRUD actions for ExclusiveOfferPage model.
 */
class ExclusiveOfferController extends BaseAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
        ];
    }

    /**
     * Displays a single ExclusiveOfferPage model.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(1),
        ]);
    }

    /**
     * Updates an existing ExclusiveOfferPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $exclusiveOfferService = new ExclusiveOfferService();
        if (Yii::$app->request->isPost) {
            $model = new ExclusiveOfferForm();
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile == null || $model->upload()) {
                $entity = $exclusiveOfferService->saveItem($model);
                return $this->redirect(['index', 'id' => 1]);
            } else {
                return 'failed '.$model->imageFile;
            }
        }

        $entity = $this->findModel($id);
        $model = $exclusiveOfferService->getItemForm($entity);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the ExclusiveOfferPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExclusiveOfferPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExclusiveOfferPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
