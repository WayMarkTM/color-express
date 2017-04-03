<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "marketing_type".
 *
 * @property integer $id
 * @property string $name
 * @property integer $charge
 *
 * @property AdvertisingConstructionReservation[] $advertisingConstructionReservations
 */
class MarketingType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marketing_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['charge'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'charge' => 'Charge',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructionReservations()
    {
        return $this->hasMany(AdvertisingConstructionReservation::className(), ['marketing_type_id' => 'id']);
    }
}
