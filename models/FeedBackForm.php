<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 17.03.2017
 * Time: 2:02
 */

namespace app\models;

use \Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;


class FeedBackForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $upload_resume;
    public $message;

    /**
     * @var UploadedFile
     */
    public $document;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required'],
            [['name', 'phone', 'email'], 'string', 'max' => 100],
            ['message', 'string', 'max' => 2000],
            [['upload_resume'],  'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, txt, pdf'],
        ];
    }

    public function upload()
    {
        if($this->document) {
            $root = Yii::$app->params['uploadFilesPath'] . 'temp/';
            FileHelper::createDirectory($root);

            $this->upload_resume = $root . Yii::$app->security->generateRandomString() . '.' . $this->document->extension;
            return $this->document->saveAs($this->upload_resume);
        }
    }

    public function deleteTemplFile()
    {
        unlink($this->upload_resume);
    }

}