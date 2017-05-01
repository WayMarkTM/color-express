<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_reservation".
 *
 * @property integer $id
 * @property integer $advertising_construction_id
 * @property integer $marketing_type_id
 * @property integer $status_id
 * @property integer $user_id
 * @property integer $employee_id
 * @property float $cost
 * @property string $from
 * @property string $to
 * @property string $thematic
 * @property \DateTime $created_at
 *
 * @property AdvertisingConstruction $advertisingConstruction
 * @property AdvertisingConstructionReservationStatus $status
 * @property MarketingType $marketingType
 * @property User $employee
 * @property User $user
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
            [['advertising_construction_id', 'status_id', 'user_id', 'marketing_type_id'], 'integer'],
            [['from', 'to'], 'safe'],
            [['cost'], 'number'],
            [['thematic'], 'string'],
            [['advertising_construction_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstruction::className(), 'targetAttribute' => ['advertising_construction_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstructionReservationStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['marketing_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MarketingType::className(), 'targetAttribute' => ['marketing_type_id' => 'id']],
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
            'cost' => 'Стоимость',
            'marketing_type_id' => 'Тип рекламы'
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarketingType()
    {
        return $this->hasOne(MarketingType::className(), ['id' => 'marketing_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(User::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
