<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/5/2017
 * Time: 9:01 PM
 */

namespace app\controllers;


use app\services\DocumentService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class DocumentsController extends Controller
{
    /**
     * @var DocumentService
     */
    private $documentService;

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

    public function actionGetDocuments($userId, $year, $month) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $documents = $this->documentService->getDocuments($userId, $year, $month);

        return [
            'documents' => $documents
        ];
    }
}