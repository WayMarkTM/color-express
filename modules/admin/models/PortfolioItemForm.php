<?php

namespace app\modules\admin\models;

use app\models\entities\File;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class PortfolioItemForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public $id;
    public $path;
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

    public function upload()
    {
        $root = Yii::$app->params['uploadFilesPath'];
        FileHelper::createDirectory($root);

        $this->path = $root.Yii::$app->security->generateRandomString().'.'. $this->imageFile->extension;
        $this->imageFile->saveAs($this->path);
        return true;
    }

}