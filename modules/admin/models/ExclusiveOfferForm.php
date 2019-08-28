<?php

namespace app\modules\admin\models;

use app\models\entities\File;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class ExclusiveOfferForm extends BaseImageForm
{
    public $id;
    public $title;
    public $formatted_text;
    public $facebook_title;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['title', 'formatted_text', 'facebook_title'], 'string'],
            [['id'], 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'imageFile' => 'Изображение',
            'formatted_text' => 'Содержимое',
            'facebook_title' => 'Заголовок для Facebook'
        ];
    }
}