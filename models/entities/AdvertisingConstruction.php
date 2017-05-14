<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction".
 *
 * @property integer $id
 * @property string $name
 * @property string $nearest_locations
 * @property string $traffic_info
 * @property boolean $has_traffic_lights
 * @property boolean $is_published
 * @property integer $address
 * @property integer $size_id
 * @property string $price
 * @property integer $type_id
 * @property string $latitude
 * @property string $longitude
 * @property string $requirements_document_path
 * @property boolean $isBusy
 *
 * @property AdvertisingConstructionSize $size
 * @property AdvertisingConstructionType $type
 * @property AdvertisingConstructionImage[] $advertisingConstructionImages
 * @property AdvertisingConstructionReservation[] $advertisingConstructionReservations
 */
class AdvertisingConstruction extends \yii\db\ActiveRecord
{
    public $isBusy;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_construction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'size_id', 'price', 'type_id'], 'required'],
            [['nearest_locations', 'traffic_info', 'latitude', 'longitude', 'requirements_document_path'], 'string'],
            [['size_id', 'type_id'], 'integer'],
            [['has_traffic_lights', 'is_published'], 'boolean'],
            [['price'], 'number'],
            [['name', 'address'], 'string', 'max' => 255],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstructionSize::className(), 'targetAttribute' => ['size_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstructionType::className(), 'targetAttribute' => ['type_id' => 'id']],
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
            'traffic_info' => 'Трафик',
            'has_traffic_lights' => 'Светофоры',
            'address' => 'Адрес',
            'size_id' => 'Формат',
            'price' => 'Цена',
            'type_id' => 'Тип',
            'latitude' => 'Широта',
            'longitude' => 'Долгота',
            'is_published' => 'Показывать на внешнем сайте',
            'requirements_document_path' => 'Технические требования'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(AdvertisingConstructionSize::className(), ['id' => 'size_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(AdvertisingConstructionType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructionImages()
    {
        return $this->hasMany(AdvertisingConstructionImage::className(), ['advertising_construction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructionReservations()
    {
        return $this->hasMany(AdvertisingConstructionReservation::className(), ['advertising_construction_id' => 'id']);
    }
}
