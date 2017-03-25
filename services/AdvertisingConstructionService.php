<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/11/2017
 * Time: 2:54 PM
 */

namespace app\services;

use app\models\entities\AdvertisingConstruction;
use app\models\entities\AdvertisingConstructionImage;
use app\models\entities\AdvertisingConstructionSize;
use app\models\entities\AdvertisingConstructionType;
use app\modules\admin\models\AdvertisingConstructionForm;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;


class AdvertisingConstructionService
{
    /**
     * @param AdvertisingConstructionForm $viewModel
     * @return integer $id
     */
    public function saveAdvertisingConstruction($viewModel) {
        $model = $viewModel->map();
        $geocodingService = new GoogleGeocodingService();

        $coordinates = $geocodingService->geocode($model->address);

        if ($coordinates) {
            $model->latitude = strval($coordinates['lat']);
            $model->longitude = strval($coordinates['long']);
        }

        $images = $this->mapToImages($viewModel->images);

        $id = $this->saveAdvertisingConstructionToDatabase($model, $images);

        return $id;
    }

    /**
     * @param AdvertisingConstruction $model
     * @param array AdvertisingConstructionImage $images
     * @return integer $id
     * @throws Exception
     * @throws \yii\db\Exception
     */
    private function saveAdvertisingConstructionToDatabase($model, $images) {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->save();

            foreach ($images as $image) {
                $model->link('advertisingConstructionImages', $image);
            }

            $transaction->commit();

            return $model->id;
        } catch (Exception $e) {
            $transaction->rollback();
        }

        throw new Exception('Failed to save Advertising Construction with related images');
    }

    /**
     * @param array $images
     * @return array AdvertisingConstructionImage
     */
    private function mapToImages($images) {
        $advertisingConstructionImages = array();
        foreach ($images as $image) {
            $acImage = new AdvertisingConstructionImage();
            $acImage->path = $image;
            array_push($advertisingConstructionImages, $acImage);
        }

        return $advertisingConstructionImages;
    }

    public static function getAdvertisingConstructionTypeDropdownItems() {
        return ArrayHelper::map(AdvertisingConstructionType::find()->all(), 'id', 'name');
    }

    public static function getAdvertisingConstructionSizeDropdownItems() {
        return ArrayHelper::map(AdvertisingConstructionSize::find()->all(), 'id', 'size');
    }
}