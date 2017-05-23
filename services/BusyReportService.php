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
    const WEEK_IN_MONTH = 4;

    public function generate($year, $fromMonth, $monthCount, $queryParams)
    {
        $search = new AdvertisingConstructionSearch();
        $constructions = $search->searchItems($queryParams, true, true);

        $data = array();
        array_push($data, $this->getColumnTitles($monthCount, $fromMonth, $queryParams['AdvertisingConstructionSearch']['type_id']));

        for($i = 0; $i < count($constructions); $i++) {
            array_push($data, $this->getExcelLine($i, $constructions, $monthCount, $fromMonth, $year));
        }

        $xls = $this->generateExcel($data, $monthCount);
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
        array_push($result, 'КФ по конкретному рекламоносителю');

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
        return $xls;
    }
}