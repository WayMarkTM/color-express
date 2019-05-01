<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "advertising_construction_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $presentation_link
 *
 * @property AdvertisingConstruction[] $advertisingConstructions
 */
class AdvertisingConstructionType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_construction_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'presentation_link'], 'string', 'max' => 255],
            ['additional_text', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тип конструкции',
            'presentation_link' => 'Ссылка на презентацию',
            'additional_text' => 'Текстовый блок под каталогом'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructions()
    {
        return $this->hasMany(AdvertisingConstruction::className(), ['type_id' => 'id']);
    }
}
