<?php

namespace app\services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

use app\models\AdvertisingConstructionSearch;
use app\models\constants\AdvertisingConstructionStatuses;
use app\models\entities\AdvertisingConstructionReservation;

class SalesReportService extends BaseNewReportService implements iReportService
{
  public function generate($year, $fromMonth, $monthCount, $queryParams)
  {
      $search = new AdvertisingConstructionSearch();
      $constructions = $search->searchItems($queryParams, true, false, true);
      $fromDate = $this->getStartDate($year, $fromMonth);
      $toDate = $this->getEndDate($year, $fromMonth, $monthCount);
      $reportStartDate = $this->getStartDateTime($year, $fromMonth);
      $reportEndDate = $this->getEndDateTime($year, $fromMonth, $monthCount);

      $data = array();

      foreach($constructions as $construction) {
        $reservations = $this->getReservations($construction, $fromDate, $toDate);
        $hasDismantling = $construction->dismantling_from != null && $construction->dismantling_to != null;
        $hasDismantlingInReportPeriod = false;
        if ($hasDismantling) {
          $dismantlingFrom = new \DateTime(date('Y-m-d', strtotime($construction->dismantling_from)));
          $dismantlingTo = new \DateTime(date('Y-m-d', strtotime($construction->dismantling_to)));
          $hasDismantlingInReportPeriod = DateService::intersects($dismantlingFrom, $dismantlingTo, $reportStartDate, $reportEndDate);
        }

        if ($hasDismantlingInReportPeriod) {
          array_push($data, $this->getDataLineFromDismantling($construction, $reservation, $dismantlingFrom, $dismantlingTo));
        }

        if (count($reservations) == 0) {
          array_push($data, $this->getDataLineFromConstruction($construction, $fromDate, $toDate));
        }

        foreach($reservations as $reservation) {
          foreach($reservation->advertisingConstructionReservationPeriods as $period) {
            $periodStartDate = new \DateTime(date('Y-m-d', strtotime($period->from)));
            $periodEndDate = new \DateTime(date('Y-m-d', strtotime($period->to)));

            if (DateService::intersects($periodStartDate, $periodEndDate, $reportStartDate, $reportEndDate)) {
                array_push($data, $this->getDataLineFromPeriod($construction, $reservation, $period));
            }
          }
        }
      }

      $xls = $this->generateExcel($monthCount, $data);
      return $this->saveSpreadsheetFile($xls);
  }

  protected function getReservations($construction, $fromDate, $toDate) {
    return AdvertisingConstructionReservation::find()
      ->where(['=', 'advertising_construction_id', $construction->id])
      ->andFilterWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::RESERVED, AdvertisingConstructionStatuses::APPROVED_RESERVED , AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::APPROVED)])
      ->andFilterWhere(['<=', 'from', $toDate])
      ->andFilterWhere(['>=', 'to', $fromDate])
      ->all();
  }

  private function getDataLineFromPeriod($construction, $reservation, $period) {
      $reservationLength = DateService::calculateIntervalLength($period->from, $period->to);
      $busyPercent = $this->calculateBusyPercent($reservationLength, $period->from);

      return [
        $construction->name,
        $construction->size->size,
        $construction->address,
        null,
        $this->formatDateRange($period->from, $period->to),
        $reservationLength,
        $busyPercent,
        $reservation->user->company,
        $reservation->thematic,
        $reservation->marketingType->name,
        $reservation->getStatusName(),
        $period->price,
        $period->price * $reservationLength,
        $reservation->user->balance,
        $reservation->user->subclients[0]->term_payment,
        $reservation->employee->surname
      ];
  }

  private function getDataLineFromConstruction($construction, $fromDate, $toDate) {
    return [
      $construction->name,
      $construction->size->size,
      $construction->address,
      null,
      $this->formatDateRange($fromDate, $toDate),
      0,
      0,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
    ];
  }

  private function getDataLineFromDismantling($construction, $reservation, $dismantlingFrom, $dismantlingTo) {
    $intervalLength = DateService::calculateIntervalLength($dismantlingFrom, $dismantlingTo);
    
    return [
      $construction->name,
      $construction->size->size,
      $construction->address,
      $this->formatDateRange($dismantlingFrom, $dismantlingTo),
      NULL,
      $intervalLength,
      "0.00",
    ];
  }

  private function calculateBusyPercent($reservationLength, $from) {
      $fromDate = new \DateTime($from);
      $month = $fromDate->format('n');
      $year = $fromDate->format('Y');
      $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

      return number_format(round(100 * $reservationLength / $daysInMonth, 2), 2, '.', '');
  }

  private function formatDateRange($from, $to) {
    $fromString = $this->formatDate($from);
    $toString = $this->formatDate($to);
    return $fromString.' - '.$toString;
  }

  private function formatDate($date) {
    $format = 'd.m.Y';
    if ($date instanceof \DateTime) {
      return $date->format($format);
    }

    return (new \DateTime($date))->format($format);
  }

  private function calculatePrice($cost, $days) {
    return number_format(round($cost / $days, 2), 2, '.', '');
  }

  private function generateExcel($monthCount, $data) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Отчет по продажам');
    $sheet->setCellValue("A1", 'Отчетный период: '.$this->getPeriodName($monthCount));
    $sheet->mergeCells('A1:P1');

    $sheet->fromArray($this->getColumnTitles(), NULL, 'A2');
    $sheet->fromArray($data, NULL, 'A3');
    $dataRowsCount = count($data);
    $dataRowsFromIndex = 3;

    $this->setStyles($sheet, $dataRowsCount);

    $sheet->setCellValue('F'.($dataRowsCount + $dataRowsFromIndex), 'Средняя');
    $sheet->setCellValue('G'.($dataRowsCount + $dataRowsFromIndex), $this->calculateAverageBusyCoefficient($data));
    for ($i = $dataRowsFromIndex; $i <= $dataRowsCount + $dataRowsFromIndex; $i++) {
      $newValue = number_format(round($sheet->getCell('G'.$i)->getValue(), 2), 2, '.', '')."%";
      $sheet->setCellValue('G'.$i, $newValue);
    }

    return $spreadsheet;
  }

  private function calculateAverageBusyCoefficient($data) {
    $busyCoefficientColumnIndex = 6;
    $sum = 0;
    foreach($data as $dataRow) {
      $sum += $dataRow[$busyCoefficientColumnIndex];
    }

    return number_format(round($sum/count($data), 2), 2, '.', '');
  }

  private function setStyles($sheet, $dataRowsCount) {
    $dataRowsEndIndex = $dataRowsCount + 2;
    $headerStyle = [
      'font' => [
        'bold' => true,
      ],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
      ],
    ];

    $dataStyle = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => 'FF000000'],
        ],
      ],
    ];

    for ($i = 'A'; $i <= 'P'; $i++) {
      $sheet->getColumnDimension($i)->setAutoSize(true);
    }

    $busyStyle= [
      'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00
    ];

    $sheet->getStyle('G3:G'.($dataRowsEndIndex + 1))->applyFromArray($busyStyle);
    $sheet->getStyle('F'.($dataRowsEndIndex + 1))->applyFromArray([
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        ],
    ]);

    $sheet->getStyle('A2:P2')->applyFromArray($headerStyle);
    $sheet->getStyle('A3:P'.$dataRowsEndIndex)->applyFromArray($dataStyle);
  }

  private function getColumnTitles() {
      return [
          'Название',
          'Размер',
          'Адрес',
          'Демонтаж',
          'Даты использования',
          'Количество дней',
          'Занятость',
          'Юр. лицо',
          'Тематика',
          'Тип рекламы',
          'Статус заказа',
          'Стоимость в день',
          'Стоимость за период',
          'Задолженность',
          'Условия оплаты',
          'Менеджер'
      ];
  }

  private function getReportMonth($reservation, $reportFromDate, $reportToDate) {
      $fromDateTime = new \DateTime($reservation->from);
      $toDateTime = new \DateTime($reservation->to);
      $reportFromDateTime = new \DateTime($reportFromDate);
      $reportToDateTime = new \DateTime($reportToDate);

      if ($fromDateTime < $reportFromDateTime) {
          $fromDateTime = $reportFromDateTime;
      }

      if ($toDateTime > $reportToDateTime) {
          $toDateTime = $reportToDateTime;
      }

      $from = $fromDateTime->format('d.m.Y');
      $to = $toDateTime->format('d.m.Y');

      return $from.' - '.$to;
  }
}