<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "site_settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class SiteSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'name'], 'required'],
            [['value', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Описание',
            'value' => 'Значение'
        ];
    }
}
