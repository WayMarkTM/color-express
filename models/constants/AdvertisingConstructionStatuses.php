<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/26/2017
 * Time: 3:46 PM
 */

namespace app\models\constants;


class AdvertisingConstructionStatuses
{
    const IN_BASKET_ORDER = 10;
    const IN_BASKET_RESERVED = 11;
    const IN_PROCESSING = 20;
    const RESERVED = 31;
    const APPROVED = 40;
    const APPROVED_RESERVED = 41;
    const DECLINED = 50;
    const CANCELLED = 255;
}