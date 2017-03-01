<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "our_client".
 *
 * @property integer $id
 * @property string $name
 * @property string $logo_url
 */
class OurClient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'our_client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'logo_url'], 'required'],
            [['name', 'logo_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'logo_url' => 'Logo Url',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\queries\OurClientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\queries\OurClientQuery(get_called_class());
    }
}
