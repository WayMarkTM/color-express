<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_reservation_status".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AdvertisingConstructionReservation[] $advertisingConstructionReservations
 */
class AdvertisingConstructionReservationStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_construction_reservation_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructionReservations()
    {
        return $this->hasMany(AdvertisingConstructionReservation::className(), ['status_id' => 'id']);
    }
}
