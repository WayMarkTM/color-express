<?php

namespace app\modules\admin\models;

use app\models\entities\File;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class PortfolioItemForm extends BaseImageForm
{
    public $id;
    public $title;
    public $isNewRecord;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['title'], 'string'],
            [['id'], 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Описание',
            'imageFile' => 'Изображение'
        ];
    }
}