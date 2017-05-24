<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_notification".
 *
 * @property integer $id
 * @property integer $advertising_construction_id
 * @property integer $status_id
 * @property integer $user_id
 * @property string $from
 * @property string $to
 * @property string $created_at
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
            [['advertising_construction_id', 'status_id', 'user_id', 'from', 'to'], 'required'],
            [['advertising_construction_id', 'status_id', 'user_id'], 'integer'],
            [['from', 'to', 'created_at'], 'safe'],
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
            'created_at' => 'Created At',
        ];
    }
}
