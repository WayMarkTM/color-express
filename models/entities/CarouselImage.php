<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "carousel_image".
 *
 * @property integer $id
 * @property integer $order
 * @property string $path
 */
class CarouselImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carousel_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'path'], 'required'],
            [['order'], 'integer'],
            [['path'], 'string', 'max' => 4000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order' => 'Порядковый номер',
            'path' => 'Путь к изображению',
        ];
    }
}
