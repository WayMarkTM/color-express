<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/23/2017
 * Time: 12:52 AM
 */

namespace app\services;

use PHPExcel_Writer_Excel2007;
use Yii;
use yii\base\NotSupportedException;
use yii\helpers\FileHelper;

class BaseReportService
{
    protected function getPath() {
        $root = Yii::$app->params['uploadFilesPath'].'reports/';
        FileHelper::createDirectory($root);
        return $root.Yii::$app->security->generateRandomString().'.xlsx';
    }

    protected function getPeriodName($period) {
        if ($period == 1) {
            return 'Ежемесячно';
        }

        if ($period == 3) {
            return 'Ежеквартально';
        }

        if ($period == 12) {
            return 'Ежегодно';
        }

        throw new NotSupportedException('Period type is not supported');
    }

    protected function getStartDate($year, $month) {
        $start = new \DateTime($year.'-'.$month.'-1');
        return $start->format('Y-m-d');
    }

    protected function getEndDate($year, $month, $period) {
        $end = new \DateTime($year.'-'.($month+$period).'-1');
        $end->modify('-1 day');
        return $end->format('Y-m-d');
    }

    protected function getMonthName($month) {
        switch ($month) {
            case 1: return 'Январь';
            case 2: return 'Февраль';
            case 3: return 'Март';
            case 4: return 'Апрель';
            case 5: return 'Май';
            case 6: return 'Июнь';
            case 7: return 'Июль';
            case 8: return 'Август';
            case 9: return 'Сентябрь';
            case 10: return 'Октябрь';
            case 11: return 'Ноябрь';
            case 12: return 'Декабрь';
        }
    }

    protected function saveExcelFile($xls) {
        $path = $this->getPath();
        $objWriter = new PHPExcel_Writer_Excel2007($xls);
        $objWriter->save($path);

        return $path;
    }
}