<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "page_metadata".
 *
 * @property integer $id
 * @property string $key
 * @property string $title
 * @property string $description
 * @property string $keywords
 */
class PageMetadata extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_metadata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 1024],
            [['description', 'keywords'], 'string', 'max' => 4000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Ключ',
            'title' => 'Заголовок страницы',
            'description' => 'Мета-тэг description',
            'keywords' => 'Мета-тэг keywords',
        ];
    }
}
