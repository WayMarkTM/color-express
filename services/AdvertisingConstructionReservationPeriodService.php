<?php
namespace app\services;

use app\models\constants\AdvertisingConstructionStatuses;
use app\models\ReservationDates;
use app\models\entities\AdvertisingConstruction;
use app\models\entities\AdvertisingConstructionReservation;
use app\models\entities\AdvertisingConstructionReservationPeriod;
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

  /**
   * @param integer $reservationId
   * @param [{ id, from, to, price }] $periods
   * 
   * @return [ isValid, message ]
   */
  function savePeriods($reservationId, $periods) {
    $reservation = AdvertisingConstructionReservation::findOne($reservationId);
    $dbReservationPeriods = $reservation->advertisingConstructionReservationPeriods;
    $periodIds = array_column($periods, 'id');

    foreach ($dbReservationPeriods as $dbReservationPeriod) {
      // modified
      if (in_array($dbReservationPeriod->id, $periodIds)) {
        $dbReservationPeriod->price = $period['price'];
        $dbReservationPeriod->from = $period['from'];
        $dbReservationPeriod->to = $period['to'];
        $dbReservationPeriod->save();
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
        $dbPeriod->save();
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

    $reservation->cost = $totalCost;
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