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
    public function intersects($from1, $to1, $from2, $to2) {
        return ($from1 >= $from2 && $from1 <= $to2) ||
               ($to1 <= $to2 && $to1 >= $from2);
    }
}