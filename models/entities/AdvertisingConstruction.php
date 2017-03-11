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
 * @property integer $has_traffic_lights
 * @property integer $address
 * @property integer $size_id
 * @property string $price
 * @property integer $type_id
 *
 * @property AdvertisingConstructionSize $size
 * @property AdvertisingConstructionType $type
 * @property AdvertisingConstructionImage[] $advertisingConstructionImages
 * @property AdvertisingConstructionReservation[] $advertisingConstructionReservations
 */
class AdvertisingConstruction extends \yii\db\ActiveRecord
{
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
            [['nearest_locations', 'traffic_info'], 'string'],
            [['has_traffic_lights', 'size_id', 'type_id'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'nearest_locations' => 'Nearest Locations',
            'traffic_info' => 'Traffic Info',
            'has_traffic_lights' => 'Has Traffic Lights',
            'address' => 'Address ID',
            'size_id' => 'Size ID',
            'price' => 'Price',
            'type_id' => 'Type ID',
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
