<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 28.05.2018
 * Time: 22:58
 */

namespace app\models;

/**
 * Class ReservationDates
 * @package app\models
 *
 * @property integer $reservationId
 * @property Date[] $dates 
 */
class ReservationDates
{
    public $reservationId;
    public $dates;
}
