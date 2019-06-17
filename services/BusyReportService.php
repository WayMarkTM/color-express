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
use PHPExcel_Style_Border;
use PHPExcel_Style_Color;
use PHPExcel_Style_Fill;
use PHPExcel_Style_NumberFormat;
use PHPExcel_Worksheet;

class BusyReportService extends BaseReportService implements iReportService
{
    const WEEK_IN_MONTH = 4;

    public function generate($year, $fromMonth, $monthCount, $queryParams)
    {
        $search = new AdvertisingConstructionSearch();
        $constructions = $search->searchItems($queryParams, true, false, true);

        $data = array();
        array_push($data, $this->getColumnTitles($monthCount, $fromMonth, $queryParams['AdvertisingConstructionSearch']['type_id']));

        for($i = 0; $i < count($constructions); $i++) {
            array_push($data, $this->getExcelLine($i, $constructions, $monthCount, $fromMonth, $year));
        }

        $xls = $this->generateExcel($data, $monthCount, count($constructions));
        return $this->saveExcelFile($xls);
    }

    private function getExcelLine($index, $constructions, $monthCount, $fromMonth, $year) {
        $result = [
            $index + 1,
            $constructions[$index]->address,
            $constructions[$index]->size->size,
        ];

        $numberOfBusyDays = 0;
        for ($i = 0; $i < $monthCount; $i++) {
            $currentMonth = $fromMonth + $i;
            if ($currentMonth > 12) {
                $currentMonth %= 12;
            }

            $fromDate = $this->getStartDate($year, $currentMonth);
            $toDate = $this->getEndDate($year, $currentMonth, 1);

            $reservations = $this->getReservations($constructions[$index], $fromDate, $toDate);

            $busyDaysPerMonth = 0;
            foreach ($reservations as $reservation) {
                $reservationStartDate = new \DateTime(date('Y-m-d', strtotime($reservation->from)));
                $reservationEndDate = new \DateTime(date('Y-m-d', strtotime($reservation->to)));
                $monthStartDate = $this->getStartDateTime($year, $currentMonth);
                $monthEndDate = $this->getEndDateTime($year, $currentMonth, 1);

                $startDate = $reservationStartDate < $monthStartDate ? $monthStartDate : $reservationStartDate;
                $endDate = $reservationEndDate > $monthEndDate ? $monthEndDate : $reservationEndDate;
                $busyDaysPerMonth += $startDate->diff($endDate)->days + 1;
            }

            $numberOfBusyDays += $busyDaysPerMonth;
            array_push($result, count($reservations) > 0 ? $busyDaysPerMonth : '');
        }

        array_push($result, $this->getConstructionBusyCoefficient($numberOfBusyDays, $year, $monthCount, $fromMonth));

        return $result;
    }

    private function getConstructionBusyCoefficient($numberOfBusyDays, $year, $period, $fromMonth) {
        $fromDate = $this->getStartDateTime($year, $fromMonth);
        $toDate = $this->getEndDateTime($year, $fromMonth, $period);
        $daysInPeriod = $fromDate->diff($toDate)->days + 1;

        return round($numberOfBusyDays*100/$daysInPeriod, 2).'%';
    }


    private function getColumnTitles($monthCount, $fromMonth, $type_id) {
        $type = AdvertisingConstructionType::findOne($type_id);
        $result = array();
        array_push($result, '');
        array_push($result, $type->name);
        array_push($result, '');

        for ($i = 0; $i < $monthCount; $i++) {
            $currentMonth = $fromMonth + $i;
            if ($currentMonth > 12) {
                $currentMonth %= 12;
            }

            array_push($result, $this->getMonthName($currentMonth));
        }

        return $result;
    }

    private function generateExcel($data, $monthCount, $constructionsCount) {
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

        $this->highlightWithColors($sheet, $constructionsCount, $monthCount);

        $this->setAverageCoefficient($sheet, $constructionsCount, $monthCount);

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getStyle('A1:A1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getStyle('C1:C1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $column = 'D';
        for ($i = 0; $i < $monthCount; $i++) {
            $sheet->getColumnDimension($column)->setWidth(10);
            $sheet->getStyle($column.'1:'.$column.'1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $column++;
        }

        $sheet->getColumnDimension($column)->setAutoSize();
        $sheet->getStyle($column.'1:'.$column.'1000')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $sheet->getStyle('A2:'.(--$column).($constructionsCount + 2))->applyFromArray($styleArray);

        $sheet->getStyle('A2:'.$column.'2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyle('C2:C'.($constructionsCount + 2))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyle($column.'2:'.$column.($constructionsCount + 2))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

        $styleArray = array(
            'font'  => array(
                'color' => array('rgb' => 'FF0000'),
            ));

        $sheet->getStyle($column.'2')->applyFromArray($styleArray);

        return $xls;
    }

    /**
     * @param $sheet PHPExcel_Worksheet
     * @param $constructionsCount integer
     * @param $monthCount integer
     */
    private function highlightWithColors($sheet, $constructionsCount, $monthCount) {
        $column = 3; $row = 3;

        for ($j = 0; $j < $constructionsCount; $j++) {
            $color = $this->random_color();
            for ($i = 0; $i < $monthCount; $i++) {
                $cell = $sheet->getCellByColumnAndRow($column + $i, $row + $j);
                if ($cell->getValue() == null || $cell->getValue() == '') {
                    $color = $this->random_color();
                    continue;
                }

                $cell->getStyle()->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => $color)
                        )
                    )
                );

                $cell->setValue('');
            }
        }
    }

    /**
     * @param $sheet PHPExcel_Worksheet
     * @param $constructionsCount integer
     * @param $monthCount integer
     */
    private function setAverageCoefficient($sheet, $constructionsCount, $monthCount) {
        $column = $monthCount + 3; $row = 3;

        $sum = 0;
        for ($i = 0; $i < $constructionsCount; $i++) {
            $cell = $sheet->getCellByColumnAndRow($column, $row + $i);
            $cell->getStyle()->getNumberFormat()->applyFromArray(
                array(
                    'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                )
            );

            $value = $cell->getValue();
            $sum += $value;
        }

        $sheet->getCellByColumnAndRow($column, $row - 1)->setValue(round($sum/$constructionsCount, 2).'%');
    }

    private function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    private function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}