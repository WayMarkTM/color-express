<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/25/2017
 * Time: 11:51 AM
 */

namespace app\modules\admin\models;

use app\models\entities\AdvertisingConstruction;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class AdvertisingConstructionForm extends Model
{
    public $id;
    public $name;
    public $address;
    public $size_id;
    public $price;
    public $type_id;
    public $nearest_locations;
    public $traffic_info;
    public $has_traffic_lights;
    public $images;
    public $document_path;
    public $is_published;

    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    /**
     * @var UploadedFile
     */
    public $documentFile;

    public function rules()
    {
        return [
            [['name', 'address', 'size_id', 'price', 'type_id'], 'required'],
            [['nearest_locations', 'traffic_info'], 'string'],
            [['size_id', 'type_id'], 'integer'],
            [['has_traffic_lights', 'is_published'], 'boolean'],
            [['price'], 'number'],
            [['name', 'address'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'nearest_locations' => 'Рядом расположены',
            'traffic_info' => 'Трафик',
            'has_traffic_lights' => 'Светофоры',
            'address' => 'Адрес',
            'size_id' => 'Формат',
            'price' => 'Цена',
            'type_id' => 'Тип',
            'imageFiles' => 'Фотографии',
            'is_published' => 'Показывать на внешнем сайте',
            'documentFile' => 'Документ с техническими требованиями к плакату'
        ];
    }

    /**
     * @return AdvertisingConstruction
     */
    public function map() {
        $model = new AdvertisingConstruction();

        $model->name = $this->name;
        $model->address = $this->address;
        $model->size_id = $this->size_id;
        $model->price = $this->price;
        $model->type_id = $this->type_id;
        $model->nearest_locations = $this->nearest_locations;
        $model->traffic_info = $this->traffic_info;
        $model->has_traffic_lights = $this->has_traffic_lights;
        $model->is_published = $this->is_published;
        $model->requirements_document_path = $this->document_path;

        return $model;
    }

    public function upload()
    {
        $root = Yii::$app->params['uploadFilesPath'].'AdvertisingConstructions/';
        FileHelper::createDirectory($root);

        if ($this->validate()) {
            $this->images = array();
            foreach ($this->imageFiles as $file) {
                $uid = (new \DateTime())->format('Y-m-d');
                $path = $root.$uid.$file->baseName.'.'. $file->extension;
                $file->saveAs($path);
                array_push($this->images, $path);
            }

            $documentPath = $root.'Documents/';
            $uid = (new \DateTime())->format('Y-m-d');
            $this->document_path = $documentPath.$uid.$this->documentFile->baseName.'.'.$this->documentFile->extension;
            $this->documentFile->saveAs($this->document_path );

            return true;
        } else {
            return false;
        }
    }

//$root = Yii::$app->params['uploadFilesPath'];
//FileHelper::createDirectory($root);
//
//$this->path = $root.$this->imageFile->baseName.'.'. $this->imageFile->extension;
//$this->imageFile->saveAs($this->path);
//return true;
}