<?php

namespace app\modules\admin\models;

use app\models\entities\File;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class BaseImageForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $path;

    public function upload()
    {
        $root = Yii::$app->params['uploadFilesPath'];
        FileHelper::createDirectory($root);

        $this->path = $root.Yii::$app->security->generateRandomString().'.'. $this->imageFile->extension;
        $this->imageFile->saveAs($this->path);
        return true;
    }

}