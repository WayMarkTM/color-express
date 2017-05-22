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
use yii\filters\AccessControl;
use yii\web\Controller;

class ReportsController extends Controller
{
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
        $file = $this->reportService->getReport();
        $file->send('user.xlsx');
    }

}