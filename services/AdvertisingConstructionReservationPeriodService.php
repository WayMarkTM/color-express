<?php
namespace app\services;

use app\models\constants\AdvertisingConstructionStatuses;
use app\models\ReservationDates;
use app\models\entities\AdvertisingConstruction;
use app\models\entities\AdvertisingConstructionReservation;
use app\models\entities\AdvertisingConstructionReservationPeriod;
use app\services\DateService;
use Yii;

class AdvertisingConstructionReservationPeriodService
{
  function getConstructionReservationDates($constructionId) {
    $periods = $this->getConstructionReservationPeriods($constructionId);
    $reservationDates = [];
    foreach ($periods as $period) {
      $tempReservationDates = new ReservationDates();
      $tempReservationDates->reservationId = $period->advertising_construction_reservation_id;
      $datePeriod = new \DatePeriod(
        new \DateTime($period->from),
        new \DateInterval('P1D'),
        new \DateTime($period->to)
      );

      $tempReservationDates->dates = [];
      foreach ($datePeriod as $key => $value) {
        array_push($tempReservationDates->dates, $value->format('Y-m-d'));
      }

      array_push($reservationDates, $tempReservationDates);
    }
    
    return $reservationDates;
  }

  function getConstructionReservationPeriods($constructionId) {
    $periods = [];
    $reservations = AdvertisingConstructionReservation::find()
      ->where(['=', 'advertising_construction_id', $constructionId])
      ->andFilterWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::RESERVED, AdvertisingConstructionStatuses::APPROVED_RESERVED , AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::APPROVED)])
      ->all();

    foreach ($reservations as $reservation) {
      foreach ($reservation->advertisingConstructionReservationPeriods as $period) {
        array_push($periods, $period);
      }
    }
    
    return $periods;
  }

  function searchPeriod($periods, $id) {
    foreach ($periods as $period) {
        if ($period['id'] == $id) {
            return $period;
        }
    }

    return null;
  }

  function validatePeriod($reservations, $period) {
    $dateService = new DateService();

    foreach ($reservations as $reservation) {
      foreach ($reservation->advertisingConstructionReservationPeriods as $reservationPeriod) {
          if ($dateService->intersects(new \DateTime($period['from']), new \DateTime($period['to']), new \DateTime($reservationPeriod->from), new \DateTime($reservationPeriod->to))) {
              return false;
          }
      }
    }

    return true;
  }

  function validatePeriods($reservation, $periods) {
    $construction = AdvertisingConstruction::findOne($reservation->advertising_construction_id);
    $reservations = AdvertisingConstructionReservation::find()
        ->where(['=', 'advertising_construction_id', $reservation->advertising_construction_id])
        ->andWhere(['!=', 'id', $reservation->id])
        ->andFilterWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::RESERVED, AdvertisingConstructionStatuses::APPROVED_RESERVED , AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::APPROVED)])
        ->all();

    $hasError = false;
    $messages = 'Конструкция '.$construction->name.' ('.$construction->address.') забронирована на даты ';
    foreach ($periods as $period) {
      if (!$this->validatePeriod($reservations, $period)) {
        if ($hasError) {
          $messages .= ', ';
        }

        $messages .= 'c '.$period['from'].' по '.$period['to'];
        $hasError = true;
      }
    }

    if ($hasError) {
      return [
        'isValid' => false,
        'message' => $messages,
      ];
    }

    return null;
  }

  function savePeriod($reservationId, $period) {
    $reservation = AdvertisingConstructionReservation::findOne($reservationId);
    $construction = AdvertisingConstruction::findOne($reservation->advertising_construction_id);
    $restReservations = AdvertisingConstructionReservation::find()
      ->where(['=', 'advertising_construction_id', $reservation->advertising_construction_id])
      ->andWhere(['!=', 'id', $reservation->id])
      ->andFilterWhere(['in', 'status_id', array(AdvertisingConstructionStatuses::RESERVED, AdvertisingConstructionStatuses::APPROVED_RESERVED , AdvertisingConstructionStatuses::IN_PROCESSING, AdvertisingConstructionStatuses::APPROVED)])
      ->all();

    if (!$this->validatePeriod($restReservations, $period)) {
      return [
        'isValid' => false,
        'message' => 'Конструкция '.$construction->name.' ('.$construction->address.') забронирована на даты c '.$period['from'].' по '.$period['to']
      ];
    }

    $dbPeriod = $period['id'] > 0 ?
      AdvertisingConstructionReservationPeriod::findOne($period['id']) :
      new AdvertisingConstructionReservationPeriod();

    $dbPeriod->advertising_construction_reservation_id = $reservationId;
    $dbPeriod->from = $period['from'];
    $dbPeriod->to = $period['to'];
    $dbPeriod->price = $period['price'];
    if (!$dbPeriod->save()) {
      return [
        'isValid'=> false,
        'message'=> 'Ошибка при создании периода '.$dbPeriod->from.' - '.$dbPeriod->to,
      ];
    }

    return [
      'isValid' => true,
      'period' => $dbPeriod,
    ];
  }

  /**
   * @param integer $reservationId
   * @param [{ id, from, to, price }] $periods
   * 
   * @return [ isValid, message ]
   */
  function savePeriods($reservationId, $periods) {
    $reservation = AdvertisingConstructionReservation::findOne($reservationId);
    $validationResult = $this->validatePeriods($reservation, $periods);
    if ($validationResult != null) {
      return $validationResult;
    }

    $dbReservationPeriods = $reservation->advertisingConstructionReservationPeriods;
    $periodIds = array_column($periods, 'id');

    foreach ($dbReservationPeriods as $dbReservationPeriod) {
      // modified
      if (in_array($dbReservationPeriod->id, $periodIds)) {
        $period = $this->searchPeriod($periods, $dbReservationPeriod->id);
        $dbReservationPeriod->price = $period['price'];
        $dbReservationPeriod->from = $period['from'];
        $dbReservationPeriod->to = $period['to'];
        if (!$dbReservationPeriod->save()) {
          return [
            'isValid' => false,
            'message' => 'Ошибка при сохранении периода '.$dbReservationPeriod->from.' - '.$dbReservationPeriod->to,
          ];
        }
      } else {
      // deleted
        $dbReservationPeriod->delete();
      }
    }

    foreach ($periods as $period) {
      if ($period['id'] == 0) {
        $dbPeriod = new AdvertisingConstructionReservationPeriod();
        $dbPeriod->advertising_construction_reservation_id = $reservationId;
        $dbPeriod->price = $period['price'];
        $dbPeriod->from = $period['from'];
        $dbPeriod->to = $period['to'];
        if (!$dbPeriod->save()) {
          return [
            'isValid'=> false,
            'message'=> 'Ошибка при создании периода '.$dbPeriod->from.' - '.$dbPeriod->to,
          ];
        }
      }
    }

    $resultPeriods = AdvertisingConstructionReservationPeriod::find()
      ->where(['=', 'advertising_construction_reservation_id', $reservationId])
      ->orderBy('from ASC')
      ->all();

    $totalCost = 0;
    $mappedPeriods = [];
    foreach ($resultPeriods as $period) {
      array_push($mappedPeriods, $this->mapPeriodForJson($period));
      $totalCost += $this->calculatePeriodCost($period);
    }

    $from = $resultPeriods[0]->from;
    $to = $resultPeriods[count($resultPeriods) - 1]->to;
    $reservation->cost = $totalCost;
    $reservation->from = $from;
    $reservation->to = $to;
    $reservation->save();

    return [
      'isValid' => true,
      'totalCost' => $totalCost,
      'periods' => $mappedPeriods,
    ];
  }

  function mapPeriodForJson($reservationPeriod) {
    return [
      'id' => $reservationPeriod->id,
      'from' => $reservationPeriod->from,
      'to' => $reservationPeriod->to,
      'price' => $reservationPeriod->price,
    ];
  }

  function calculatePeriodCost($reservationPeriod) {
    $days = (new \DateTime($reservationPeriod->to))->diff(new \DateTime($reservationPeriod->from))->days + 1;
    return round($days * $reservationPeriod->price, 2);
  }
}

?>