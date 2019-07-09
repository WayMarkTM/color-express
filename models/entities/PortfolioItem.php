<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "portfolio_item".
 *
 * @property integer $id
 * @property string $title
 * @property string $image_url
 */
class PortfolioItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'portfolio_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_url'], 'required'],
            [['title'], 'string', 'max' => 4000],
            [['image_url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Описание',
            'image_url' => 'Ссылка на изображение',
        ];
    }
}
