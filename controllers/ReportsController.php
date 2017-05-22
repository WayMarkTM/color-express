<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 22.05.2017
 * Time: 19:46
 */

namespace app\controllers;


use app\services\AdvertisingConstructionReservationService;
use app\services\ReportService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class ReportsController extends Controller
{
    /**
     * @var ReportService
     */
    private $reportService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['download'], //only be applied to
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['download'],
                        'roles' => ['employee'],
                    ],
                ],
            ],
        ];
    }

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

    public function init() {
        $this->reportService = new ReportService();
        parent::init();
    }


    public function actionDownload() {
        $filepath = $this->reportService->getReport(Yii::$app->request->queryParams);
        $storagePath = Yii::getAlias('@app/web/');

        if (!is_file("$storagePath/$filepath")) {
            throw new \yii\web\NotFoundHttpException('The file does not exists.');
        }

        return Yii::$app->response->sendFile("$storagePath/$filepath");
    }

}