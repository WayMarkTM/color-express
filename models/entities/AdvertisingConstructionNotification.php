<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_notification".
 *
 * @property integer $id
 * @property integer $advertising_construction_id
 * @property integer $user_id
 * @property string $created_at
 *
 * @property AdvertisingConstruction $advertisingConstruction
 * @property User $user
 */
class AdvertisingConstructionNotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_construction_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertising_construction_id', 'user_id'], 'required'],
            [['advertising_construction_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['advertising_construction_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstruction::className(), 'targetAttribute' => ['advertising_construction_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'created_at' => 'Created At',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
