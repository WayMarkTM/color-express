<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_reservation_period".
 *
 * @property integer $id
 * @property integer $advertising_construction_reservation_id
 * @property string $from
 * @property string $to
 * @property integer $price
 *
 * @property AdvertisingConstructionReservation $advertisingConstructionReservation
 */
class AdvertisingConstructionReservationPeriod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_construction_reservation_period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertising_construction_reservation_id', 'from', 'to', 'price'], 'required'],
            [['advertising_construction_reservation_id'], 'integer'],
            [['price'], 'number'],
            [['from', 'to'], 'safe'],
            [['advertising_construction_reservation_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstructionReservation::className(), 'targetAttribute' => ['advertising_construction_reservation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advertising_construction_reservation_id' => 'Advertising Construction Reservation ID',
            'from' => 'From',
            'to' => 'To',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructionReservation()
    {
        return $this->hasOne(AdvertisingConstructionReservation::className(), ['id' => 'advertising_construction_reservation_id']);
    }
}
