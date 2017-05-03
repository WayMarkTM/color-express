<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 6:35 PM
 */

namespace app\models;


use app\services\DateService;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class AddDocumentForm extends Model
{
    public $month;
    public $year;
    public $path;
    public $subclientId;
    public $userId;
    public $filename;

    /**
     * @var UploadedFile
     */
    public $documentFile;

    public function rules()
    {
        return [
            [['documentFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx, pdf'],
            [['month', 'year'], 'required'],
            ['year', 'compare', 'compareValue' => DateService::$YEAR_FROM, 'operator' => '>=', 'type' => 'number'],
            ['year', 'compare', 'compareValue' => DateService::$YEAR_TO, 'operator' => '<=', 'type' => 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'documentFile' => 'Документ',
            'month' => 'Месяц',
            'year' => 'Год'
        ];
    }

    public function upload($userId)
    {
        $root = Yii::$app->params['uploadFilesPath'].'/documents/'.$userId.'/'.$this->year.'/'.$this->month.'/';
        FileHelper::createDirectory($root);
        $this->filename = $this->documentFile->name;
        $this->path = Yii::$app->security->generateRandomString().'.'. $this->documentFile->extension;
        $path = $root.$this->path;
        $this->documentFile->saveAs($path);
        return true;
    }

}