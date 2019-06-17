<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\AdvertisingConstructionForm;
use Yii;
use app\models\entities\AdvertisingConstruction;
use app\models\AdvertisingConstructionSearch;
use app\services\AdvertisingConstructionService;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * AdvertisingConstructionController implements the CRUD actions for AdvertisingConstruction model.
 */
class ConstructionController extends BaseAdminController
{
    /**
     * @var AdvertisingConstructionService
     */
    private $advertisingConstructionService;

    public function init() {
        $this->advertisingConstructionService = new AdvertisingConstructionService();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
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

    /**
     * Lists all AdvertisingConstruction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertisingConstructionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);

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
            $model->documentFile = UploadedFile::getInstance($model, 'documentFile');
            if ($model->dismantling_from != null) {
                $model->dismantling_from = \DateTime::createFromFormat('d.m.Y', $model->dismantling_from)->format('Y-m-d');
            }

            if ($model->dismantling_to != null) {
                $model->dismantling_to = \DateTime::createFromFormat('d.m.Y', $model->dismantling_to)->format('Y-m-d');
            }

            if ($model->upload()) {
                $id = $this->advertisingConstructionService->saveAdvertisingConstruction($model);
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
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = AdvertisingConstructionForm::mapEntity($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->documentFile = UploadedFile::getInstance($model, 'documentFile');
            if ($model->dismantling_from != null) {
                $model->dismantling_from = \DateTime::createFromFormat('d.m.Y', $model->dismantling_from)->format('Y-m-d');
            }

            if ($model->dismantling_to != null) {
                $model->dismantling_to = \DateTime::createFromFormat('d.m.Y', $model->dismantling_to)->format('Y-m-d');
            }

            if ($model->upload()) {
                $id = $this->advertisingConstructionService->saveAdvertisingConstruction($model);
                return $this->redirect(['view', 'id' => $id]);
            }

            throw new Exception('Something went wrong with updating entity.');
        }

        $sizes = AdvertisingConstructionService::getAdvertisingConstructionSizeDropdownItems();
        $types = AdvertisingConstructionService::getAdvertisingConstructionTypeDropdownItems();
        return $this->render('update', [
            'model' => $model,
            'sizes' => $sizes,
            'types' => $types
        ]);
    }

    public function actionDeleteImage() {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        /* imageId */
        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax) {
            try {
                $this->advertisingConstructionService->deleteImage($model['imageId']);
            } catch (\Exception $exception) {
                return [
                    'isValid' => false,
                    'message' => $exception->getMessage()
                ];
            }

            return [
                'isValid' => true
            ];
        }

        return [];
    }


    /**
     * Deletes an existing AdvertisingConstruction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->advertisingConstructionService->deleteConstruction($id);
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
