<?php

namespace app\modules\admin\models;

use app\models\entities\File;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class CarouselItemForm extends BaseImageForm
{
    public $id;
    public $order;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['order'], 'number'],
            [['id'], 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'order' => 'Порядковый номер',
            'imageFile' => 'Изображение'
        ];
    }
}