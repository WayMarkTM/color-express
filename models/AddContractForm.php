<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 7/11/2017
 * Time: 12:01 AM
 */

namespace app\models;


use app\services\DateService;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class AddContractForm extends Model
{
    public $path;
    public $subclientId;
    public $userId;
    public $year;
    public $filename;

    /**
     * @var UploadedFile
     */
    public $documentFile;

    public function rules()
    {
        return [
            [['documentFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx, pdf'],
            [['year'], 'required'],
            ['year', 'compare', 'compareValue' => DateService::$YEAR_FROM, 'operator' => '>=', 'type' => 'number'],
            ['year', 'compare', 'compareValue' => DateService::$YEAR_TO, 'operator' => '<=', 'type' => 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'documentFile' => 'Договор',
            'year' => 'Год'
        ];
    }

    public function upload($userId)
    {
        $root = Yii::$app->params['uploadFilesPath'].'/contracts/'.$userId.'/'.$this->year.'/';
        FileHelper::createDirectory($root);
        $this->filename = $this->documentFile->name;
        $this->path = Yii::$app->security->generateRandomString().'.'. $this->documentFile->extension;
        $path = $root.$this->path;
        $this->documentFile->saveAs($path);
        return true;
    }
}