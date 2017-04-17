<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/3/2017
 * Time: 9:28 PM
 */

namespace app\services;


class DateService
{
    public static $FULL_DATE_FORMAT = 'Y-m-d H:i-s';

    public static $YEAR_FROM = 1900;
    public static $YEAR_TO = 2200;

    public function intersects($from1, $to1, $from2, $to2) {
        return ($from1 >= $from2 && $from1 <= $to2) ||
               ($to1 <= $to2 && $to1 >= $from2);
    }

    public static function comparator($a, $b) {
        if ($a == $b) {
            return 0;
        }

        return $a < $b ? -1 : 1;
    }

    public static function getMonthsNames() {
        return array(1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 	4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');
    }
}