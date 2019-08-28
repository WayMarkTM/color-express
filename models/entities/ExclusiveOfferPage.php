<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "exclusive_offer_page".
 *
 * @property integer $id
 * @property string $formatted_text
 * @property string $image_path
 * @property string $title
 * @property string $facebook_title
 */
class ExclusiveOfferPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exclusive_offer_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['formatted_text', 'image_path', 'title', 'facebook_title'], 'required'],
            [['formatted_text'], 'string'],
            [['image_path'], 'string', 'max' => 4000],
            [['title', 'facebook_title'], 'string', 'max' => 5000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'formatted_text' => 'Содержимое',
            'image_path' => 'Ссылка на изображение',
            'title' => 'Заголовок',
            'facebook_title' => 'Заголовок для Facebook',
        ];
    }
}
