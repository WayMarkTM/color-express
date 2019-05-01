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
use app\models\entities\MarketingType;
use app\modules\admin\models\AdvertisingConstructionForm;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;


class AdvertisingConstructionService
{
    /**
     * @param AdvertisingConstructionForm $viewModel
     * @return int $id
     */
    public function saveAdvertisingConstruction($viewModel) {
        $model = $viewModel->map($viewModel->id);

        if ($viewModel->use_manual_coordinates) {
            $model->latitude = $viewModel->latitude;
            $model->longitude = $viewModel->longitude;
        } else {
            $geocodingService = new GoogleGeocodingService();
            $coordinates = $geocodingService->geocode($model->address);

            if ($coordinates) {
                $model->latitude = strval($coordinates['lat']);
                $model->longitude = strval($coordinates['long']);
            }
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
     * @param integer $imageId
     */
    public function deleteImage($imageId) {
        AdvertisingConstructionImage::findOne($imageId)->delete();
    }

    /**
     * @param integer $id
     * @throws Exception
     */
    public function deleteConstruction($id) {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = AdvertisingConstruction::findOne($id);
            foreach ($model->advertisingConstructionImages as $image) {
                $this->deleteImage($image->id);
            }

            $model->delete();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw new Exception('Failed to save Advertising Construction with related images');
        }
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

    /**
     * @return array
     */
    public static function getAdvertisingConstructionTypeDropdownItems() {
        return ArrayHelper::map(AdvertisingConstructionType::find()->all(), 'id', 'name');
    }

    public static function getAdvertisingConstructionTypes() {
        return AdvertisingConstructionType::find()->all();
    }

    public static function getAdvertisingConstructionSizeDropdownItems($type_id = null) {
        if ($type_id == null) {
            return ArrayHelper::map(AdvertisingConstructionSize::find()->all(), 'id', 'size');
        }

        $constructionSizes = AdvertisingConstruction::find()
            ->where(['=', 'type_id', $type_id])
            ->select(['size_id'])
            ->distinct()
            ->all();

        $size_ids = array();
        foreach ($constructionSizes as $constructionSize) {
            array_push($size_ids, $constructionSize->size_id);
        }

        return ArrayHelper::map(AdvertisingConstructionSize::find()->where(['in', 'id', $size_ids])->all(), 'id', 'size');
    }

    public static function getMarketingTypeDropdownItems() {
        return ArrayHelper::map(MarketingType::find()->all(), 'id', 'name');
    }
}