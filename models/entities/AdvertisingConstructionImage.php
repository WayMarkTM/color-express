<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_image".
 *
 * @property integer $advertising_construction_id
 * @property integer $file_id
 *
 * @property AdvertisingConstruction $advertisingConstruction
 * @property File $file
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
            [['advertising_construction_id', 'file_id'], 'required'],
            [['advertising_construction_id', 'file_id'], 'integer'],
            [['advertising_construction_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingConstruction::className(), 'targetAttribute' => ['advertising_construction_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'advertising_construction_id' => 'Advertising Construction ID',
            'file_id' => 'File ID',
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
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }
}
