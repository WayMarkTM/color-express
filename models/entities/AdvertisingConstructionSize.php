<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_size".
 *
 * @property integer $id
 * @property string $size
 *
 * @property AdvertisingConstruction[] $advertisingConstructions
 */
class AdvertisingConstructionSize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_construction_size';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'size' => 'Size',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructions()
    {
        return $this->hasMany(AdvertisingConstruction::className(), ['size_id' => 'id']);
    }
}
