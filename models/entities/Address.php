<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $housing
 *
 * @property AdvertisingConstruction[] $advertisingConstructions
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city', 'street', 'house'], 'required'],
            [['city', 'street', 'house', 'housing'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'street' => 'Street',
            'house' => 'House',
            'housing' => 'Housing',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructions()
    {
        return $this->hasMany(AdvertisingConstruction::className(), ['address_id' => 'id']);
    }
}
