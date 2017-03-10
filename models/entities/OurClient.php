<?php

namespace app\models\entities;

use app\queries\OurClientQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "our_client".
 *
 * @property integer $id
 * @property string $name
 * @property string $logo_url
 */
class OurClient extends ActiveRecord
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
            'name' => 'Название',
            'logo_url' => 'Логотип',
        ];
    }

    /**
     * @inheritdoc
     * @return OurClientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OurClientQuery(get_called_class());
    }
}
