<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/25/2017
 * Time: 11:51 AM
 */

namespace app\modules\admin\models;

use app\models\constants\AdvertisingConstructionSizes;
use app\models\constants\AdvertisingConstructionTypes;
use app\models\entities\AdvertisingConstruction;
use app\models\entities\AdvertisingConstructionImage;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class AdvertisingConstructionForm extends Model
{
    public $id;
    public $name;
    public $address;
    public $size_id;
    public $price;
    public $type_id;
    public $nearest_locations;
    public $has_traffic_lights;
    public $images;
    public $uploaded_images;
    public $document_path;
    public $is_published;
    public $has_stock;
    public $latitude;
    public $longitude;
    public $use_manual_coordinates;
    public $youtube_ids;

    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    /**
     * @var UploadedFile
     */
    public $documentFile;

    public function rules()
    {
        return [
            [['name', 'address', 'size_id', 'price', 'type_id'], 'required'],
            [['nearest_locations', 'latitude', 'longitude'], 'string'],
            [['size_id', 'type_id'], 'integer'],
            [['has_traffic_lights', 'is_published', 'use_manual_coordinates', 'has_stock'], 'boolean'],
            [['price'], 'number'],
            [['youtube_ids'], 'string'],
            [['name', 'address'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'nearest_locations' => 'Рядом расположены',
            'has_traffic_lights' => 'Светофоры',
            'address' => 'Адрес',
            'size_id' => 'Формат',
            'price' => 'Цена',
            'type_id' => 'Тип',
            'imageFiles' => 'Фотографии',
            'is_published' => 'Показывать на внешнем сайте',
            'has_stock' => 'На акции',
            'documentFile' => 'Документ с техническими требованиями к плакату',
            'latitude' => 'Широта',
            'longitude' => 'Долгота',
            'use_manual_coordinates' => 'Использовать ручной ввод координат (в противном случае используется сторонний API для получения координат по адресу)',
            'youtube_ids' => 'ID видео из youtube, разделенные ";"'
        ];
    }

    /**
     * @param integer $id
     * @return AdvertisingConstruction
     */
    public function map($id = null) {
        $model = $id == null ?
            new AdvertisingConstruction() :
            AdvertisingConstruction::findOne($id);

        $model->name = $this->name;
        $model->address = $this->address;
        $model->size_id = $this->size_id;
        $model->price = $this->price;
        $model->type_id = $this->type_id;
        $model->nearest_locations = $this->nearest_locations;
        $model->has_traffic_lights = $this->has_traffic_lights;
        $model->has_stock = $this->has_stock;
        $model->is_published = $this->is_published;
        $model->requirements_document_path = $this->document_path;
        $model->youtube_ids = $this->youtube_ids;

        return $model;
    }

    public function upload()
    {
        $root = Yii::$app->params['uploadFilesPath'].'Construction/';
        FileHelper::createDirectory($root);

        if ($this->validate()) {
            $this->images = array();
            foreach ($this->imageFiles as $file) {
                $path = $root.Yii::$app->security->generateRandomString().'.'. $file->extension;
                $file->saveAs($path);
                array_push($this->images, $path);
            }

            if ($this->documentFile != null) {
                $documentPath = $root . 'Documents/';
                FileHelper::createDirectory($documentPath);
                $this->document_path = $documentPath . Yii::$app->security->generateRandomString() .  '.' . $this->documentFile->extension;
                $this->documentFile->saveAs($this->document_path);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param integer $id
     * @return AdvertisingConstructionForm
     */
    public static function mapEntity($id) {
        $entity = AdvertisingConstruction::findOne($id);

        $model = new AdvertisingConstructionForm();

        if ($entity == null) {
            return $model;
        }

        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->address = $entity->address;
        $model->size_id = $entity->size_id;
        $model->price = $entity->price;
        $model->type_id = $entity->type_id;
        $model->nearest_locations = $entity->nearest_locations;
        $model->has_traffic_lights = $entity->has_traffic_lights;
        $model->has_stock = $entity->has_stock;
        $model->is_published = $entity->is_published;
        $model->document_path = $entity->requirements_document_path;
        $model->latitude = $entity->latitude;
        $model->longitude = $entity->longitude;
        $model->youtube_ids = $entity->youtube_ids;
        $model->use_manual_coordinates = true;

        $model->uploaded_images = array();

        foreach ($entity->advertisingConstructionImages as $entityImage) {
            array_push($model->uploaded_images, $entityImage);
        }

        return $model;
    }

    public static function getLightsType($typeId, $sizeId) {
        $external = 'внешняя';
        $internal = 'внутренняя';

        if ($typeId == AdvertisingConstructionTypes::BRANDMAWER) {
            return $external;
        }

        if ($typeId == AdvertisingConstructionTypes::WALL_LIGHT_BOX || $typeId == AdvertisingConstructionTypes::OVERROOF_LIGHT_BOX || $typeId == AdvertisingConstructionTypes::METRO) {
            return $internal;
        }

        if ($typeId == AdvertisingConstructionTypes::ADVERTISING_CONSTRUCTION_ON_ROAD) {
            if ($sizeId == AdvertisingConstructionSizes::_1_8__12) {
                return $external;
            }

            if ($sizeId == AdvertisingConstructionSizes::_1_8__36) {
                return $internal;
            }
        }

        if ($typeId == AdvertisingConstructionTypes::SHIELD_ADVERTISING_CONSTRUCTION) {
            if ($sizeId == AdvertisingConstructionSizes::_4_8) {
                return $internal;
            }

            if ($sizeId == AdvertisingConstructionSizes::_3_9 || $sizeId == AdvertisingConstructionSizes::_3_12) {
                return $external;
            }
        }

        return null;
    }

//$root = Yii::$app->params['uploadFilesPath'];
//FileHelper::createDirectory($root);
//
//$this->path = $root.$this->imageFile->baseName.'.'. $this->imageFile->extension;
//$this->imageFile->saveAs($this->path);
//return true;
}