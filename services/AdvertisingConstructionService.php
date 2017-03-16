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
    /**
     * @param ..\models\entities\AdvertisingConstruction $viewModel
     */
    public function saveAdvertisingConstruction($viewModel) {
        $geocodingService = new GoogleGeocodingService();

        $coordinates = $geocodingService->geocode($viewModel->address);

        if ($coordinates) {
            $viewModel->latitude = strval($coordinates['lat']);
            $viewModel->longitude = strval($coordinates['long']);
        }

        $viewModel->save();
    }

    public static function getAdvertisingConstructionTypeDropdownItems() {
        return ArrayHelper::map(AdvertisingConstructionType::find()->all(), 'id', 'name');
    }

    public static function getAdvertisingConstructionSizeDropdownItems() {
        return ArrayHelper::map(AdvertisingConstructionSize::find()->all(), 'id', 'size');
    }
}