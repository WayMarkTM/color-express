<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/5/2017
 * Time: 9:01 PM
 */

namespace app\controllers;


use app\models\AddContractForm;
use app\models\AddDocumentForm;
use app\models\entities\Contract;
use app\models\entities\Document;
use app\models\entities\Subclient;
use app\services\DocumentService;
use app\services\SubclientService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;
use yii\widgets\ActiveForm;

class DocumentsController extends Controller
{
    /**
     * @var DocumentService
     */
    private $documentService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['get-documents-calendar', 'get-subclient-documents-calendar', 'get-contracts', 'get-documents', 'delete-document', 'delete-contract', 'upload-validation', 'upload-contract-validation', 'delete-subclient', 'update-term-payment'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['delete-document', 'delete-contract', 'upload-validation', 'upload-contract-validation', 'delete-subclient', 'update-term-payment'],
                        'roles' => ['employee'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['get-documents-calendar', 'get-subclient-documents-calendar', 'get-documents', 'get-contracts'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init() {
        $this->documentService = new DocumentService();
        parent::init();
    }

    public function actionGetDocumentsCalendar($userId) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $calendar = $this->documentService->getDocumentsCalendar($userId);
        return [
            'calendar' => $calendar
        ];
    }

    public function actionGetSubclientDocumentsCalendar($userId, $subclientId) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $calendar = $this->documentService->getDocumentsCalendar($userId, $subclientId);
        return [
            'calendar' => $calendar
        ];
    }

    public function actionGetDocuments($userId, $year, $month, $subclientId = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $documents = $this->documentService->getDocuments($userId, $year, $month, $subclientId);

        return [
            'documents' => $documents
        ];
    }

    public function actionGetContracts($userId, $year, $subclientId = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $contracts = $this->documentService->getContracts($userId, $year, $subclientId);

        return [
            'contracts' => $contracts
        ];
    }

    public function actionUploadValidation() {
        $documentForm = new AddDocumentForm();
        if (Yii::$app->request->isAjax && $documentForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($documentForm);
        }
    }

    public function actionUploadContractValidation() {
        $contractForm = new AddContractForm();
        if (Yii::$app->request->isAjax && $contractForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($contractForm);
        }
    }

    public function actionDeleteDocument($documentId) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $currentUserId = Yii::$app->user->getId();

        if ($currentUserId == null) {
            throw new UnauthorizedHttpException();
        }

        Document::findOne($documentId)->delete();
    }

    public function actionDeleteContract($contractId) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $currentUserId = Yii::$app->user->getId();

        if ($currentUserId == null) {
            throw new UnauthorizedHttpException();
        }

        Contract::findOne($contractId)->delete();
    }

    public function actionDeleteSubclient($id) {
        if (!$id) {
            return;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $documents = Document::find()
            ->where(['=', 'subclient_id', $id])
            ->all();
        foreach($documents as $document) {
            $document->delete();
        }

        Subclient::findOne($id)->delete();
    }

    public function actionUpdateTermPayment() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && !empty($model)) {
            $subclientService = new SubclientService();
            $subclientService->updateTermPayment($model['subclientId'], $model['termPayment']);

            return ['success' => true];
        }

        return new MethodNotAllowedHttpException();
    }


}