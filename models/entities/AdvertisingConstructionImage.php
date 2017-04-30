<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_image".
 *
 * @property integer $advertising_construction_id
 * @property integer $id
 *
 * @property AdvertisingConstruction $advertisingConstruction
 * @property string path
 */
class AdvertisingConstructionImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_construction_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertising_construction_id', 'path'], 'required'],
            [['advertising_construction_id'], 'integer'],
            [['path'], 'string'],
            [['advertising_construction_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstruction::className(), 'targetAttribute' => ['advertising_construction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'advertising_construction_id' => 'Advertising Construction ID',
            'path' => 'Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstruction()
    {
        return $this->hasOne(AdvertisingConstruction::className(), ['id' => 'advertising_construction_id']);
    }
}
