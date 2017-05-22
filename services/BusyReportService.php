<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/23/2017
 * Time: 1:01 AM
 */

namespace app\services;


use app\models\AdvertisingConstructionSearch;
use app\models\entities\AdvertisingConstruction;
use app\models\entities\AdvertisingConstructionType;
use PHPExcel_Style_Fill;

class BusyReportService extends BaseReportService implements iReportService
{

    public function generate($year, $fromMonth, $monthCount, $queryParams)
    {
        $search = new AdvertisingConstructionSearch();
        $constructions = $search->searchItems($queryParams, true, true);
        $fromDate = $this->getStartDate($year, $fromMonth);
        $toDate = $this->getEndDate($year, $fromMonth, $monthCount);

        $data = array();
        array_push($data, $this->getColumnTitles($monthCount, $fromMonth, $queryParams['AdvertisingConstructionSearch']['type_id']));

        $xls = $this->generateExcel($data, $monthCount);
        return $this->saveExcelFile($xls);
    }

    private function getColumnTitles($monthCount, $fromMonth, $type_id) {
        $type = AdvertisingConstructionType::findOne($type_id);
        $result = array();
        array_push($result, '');
        array_push($result, $type->name);
        array_push($result, '');

        for ($i = 0; $i < $monthCount; $i++) {
            array_push($result, $this->getMonthName($fromMonth + $i));
            array_push($result, '');
            array_push($result, '');
            array_push($result, '');
        }

        array_push($result, '44%'); // TODO: Calculate coefficient.

        return $result;
    }

    private function generateExcel($data, $monthCount) {
        $xls = new \PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Отчет по занятости');

        $sheet->fromArray($data, null, 'A2');

        $sheet->getStyle('B2')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFFCC')
                )
            )
        );

        $WEEK_IN_MONTH = 4; $offset = $monthCount * $WEEK_IN_MONTH; $currentColumn = 'D';
        for ($i = 0; $i < $monthCount; $i++) {
            $range = $currentColumn.'2:';
            for ($j = 0; $j < $WEEK_IN_MONTH; $j++) {
                $currentColumn++;
            }

            $range = $range.$currentColumn.'2';

            $sheet->mergeCells($range);
        }

        return $xls;
    }
}