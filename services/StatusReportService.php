<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/23/2017
 * Time: 12:50 AM
 */

namespace app\services;

use app\models\AdvertisingConstructionSearch;
use app\models\constants\AdvertisingConstructionStatuses;
use app\models\entities\AdvertisingConstructionReservation;
use PHPExcel_Style;
use PHPExcel_Style_Alignment;

class StatusReportService extends BaseReportService implements iReportService
{
    public function generate($year, $fromMonth, $monthCount, $queryParams)
    {
        $search = new AdvertisingConstructionSearch();
        $constructions = $search->searchItems($queryParams, true, true);
        $fromDate = $this->getStartDate($year, $fromMonth);
        $toDate = $this->getEndDate($year, $fromMonth, $monthCount);

        $data = array();

        array_push($data, $this->getColumnTitles());

        foreach($constructions as $construction) {
            /**
             * @var $reservations array|AdvertisingConstructionReservation
             */
            $reservations = $this->getReservations($construction, $fromDate, $toDate);

            foreach($reservations as $reservation) {
                array_push($data, $this->getExcelDataLine($construction, $reservation));
            }
        }

        $xls = $this->generateExcel($monthCount, $data);
        return $this->saveExcelFile($xls);
    }

    private function getExcelDataLine($construction, $reservation) {
        return [
            $construction->name,
            $this->getReportMonth($reservation),
            $reservation->user->company,
            $reservation->thematic,
            $reservation->marketingType->name
        ];
    }

    private function generateExcel($monthCount, $data) {
        $xls = new \PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Отчет по статусу');
        $sheet->setCellValue("A1", 'Отчетный период: '.$this->getPeriodName($monthCount));
        $sheet->mergeCells('A1:E1');

        $sheet->fromArray($data, null, 'A2');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $this->setHeaderStyle($sheet->getStyle('A2'));
        $this->setHeaderStyle($sheet->getStyle('B2'));
        $this->setHeaderStyle($sheet->getStyle('C2'));
        $this->setHeaderStyle($sheet->getStyle('D2'));
        $this->setHeaderStyle($sheet->getStyle('E2'));

        return $xls;
    }

    /**
     * @param $style PHPExcel_Style
     */
    private function setHeaderStyle($style) {
        $style->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $style->getFont()->setBold(true);

    }

    private function getColumnTitles() {
        return [
            'Название',
            'Месяц',
            'Юр. лицо',
            'Тематика',
            'Статус'
        ];
    }

    private function getReportMonth($reservation) {
        $fromMonth = (new \DateTime($reservation->from))->format('n');
        $toMonth = (new \DateTime($reservation->to))->format('n');

        if ($fromMonth == $toMonth) {
            return $this->getMonthName($fromMonth);
        }

        return $this->getMonthName($fromMonth).' - '.$this->getMonthName($toMonth);
    }
}