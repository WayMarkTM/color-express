<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 22.05.2017
 * Time: 19:48
 */

namespace app\services;

use Yii;
use yii\base\NotSupportedException;

class ReportService
{
    const BUSY_REPORT = 1;
    const STATUS_REPORT = 2;

    private $dateService;

    function __construct() {
        $this->dateService = new DateService();
    }

    /**
     * @param array $queryParams
     * @return object Excel Response
     * @throws NotSupportedException
     * @throws \yii\base\InvalidConfigException
     */
    public function getReport($queryParams) {
        $reportType = $queryParams['type'];
        $fromMonth = $queryParams['from'];
        $year = $queryParams['year'];
        $monthCount = $queryParams['period'];

        /**
         * @var $reportService iReportService
         */
        $reportService = null;

        if ($reportType == $this::BUSY_REPORT) {
            $reportService = new BusyReportService();
        }

        if ($reportType == $this::STATUS_REPORT) {
            $reportService = new StatusReportService();
        }

        if ($reportService == null) {
            throw new NotSupportedException('Report type not supported');
        }

        return $reportService->generate($year, $fromMonth, $monthCount, $queryParams);
    }
}