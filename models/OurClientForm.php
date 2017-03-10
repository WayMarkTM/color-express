<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 10.03.2017
 * Time: 13:20
 */

namespace app\models;

use app\models\entities\File;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class OurClientForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public $path;
    public $name;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['name'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'imageFile' => 'Логотип'
        ];
    }

    public function upload()
    {
        $root = Yii::$app->params['uploadFilesPath'];
        FileHelper::createDirectory($root);

        $this->path = $root.$this->imageFile->baseName.'.'. $this->imageFile->extension;
        $this->imageFile->saveAs($this->path);
        return true;
    }

}