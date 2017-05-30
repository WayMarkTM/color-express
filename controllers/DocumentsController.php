<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/5/2017
 * Time: 9:01 PM
 */

namespace app\controllers;


use app\models\AddDocumentForm;
use app\models\entities\Document;
use app\services\DocumentService;
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
                'only' => ['get-documents-calendar', 'get-subclient-documents-calendar', 'get-documents', 'delete-document', 'upload-validation'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['delete-document', 'upload-validation'],
                        'roles' => ['employee'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['get-documents-calendar', 'get-subclient-documents-calendar', 'get-documents'],
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

    public function actionGetDocuments($userId, $year, $month, $subclientId) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $documents = $this->documentService->getDocuments($userId, $year, $month, $subclientId);

        return [
            'documents' => $documents
        ];
    }

    public function actionUploadValidation() {
        $documentForm = new AddDocumentForm();
        if (Yii::$app->request->isAjax && $documentForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($documentForm);
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
}