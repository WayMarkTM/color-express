<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/11/2017
 * Time: 2:54 PM
 */

namespace app\services;

use app\models\entities\AdvertisingConstructionSize;
use app\models\entities\AdvertisingConstructionType;
use yii\helpers\ArrayHelper;


class AdvertisingConstructionService
{
    public static function getAdvertisingConstructionTypeDropdownItems() {
        return ArrayHelper::map(AdvertisingConstructionType::find()->all(), 'id', 'name');
    }

    public static function getAdvertisingConstructionSizeDropdownItems() {
        return ArrayHelper::map(AdvertisingConstructionSize::find()->all(), 'id', 'size');
    }
}