<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_reservation".
 *
 * @property integer $id
 * @property integer $advertising_construction_id
 * @property integer $status_id
 * @property integer $user_id
 * @property string $from
 * @property string $to
 *
 * @property AdvertisingConstruction $advertisingConstruction
 * @property AdvertisingConstructionReservationStatus $status
 */
class AdvertisingConstructionReservation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_construction_reservation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertising_construction_id', 'status_id', 'user_id', 'from', 'to'], 'required'],
            [['advertising_construction_id', 'status_id', 'user_id'], 'integer'],
            [['from', 'to'], 'safe'],
            [['advertising_construction_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstruction::className(), 'targetAttribute' => ['advertising_construction_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstructionReservationStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advertising_construction_id' => 'Advertising Construction ID',
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
            'from' => 'From',
            'to' => 'To',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstruction()
    {
        return $this->hasOne(AdvertisingConstruction::className(), ['id' => 'advertising_construction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(AdvertisingConstructionReservationStatus::className(), ['id' => 'status_id']);
    }
}
