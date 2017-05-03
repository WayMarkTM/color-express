<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/25/2017
 * Time: 11:51 AM
 */

namespace app\modules\admin\models;

use app\models\entities\AdvertisingConstruction;
use app\models\entities\AdvertisingConstructionImage;
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
    public $uploaded_images;
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
     * @param integer $id
     * @return AdvertisingConstruction
     */
    public function map($id = null) {
        $model = $id == null ?
            new AdvertisingConstruction() :
            AdvertisingConstruction::findOne($id);

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
        $root = Yii::$app->params['uploadFilesPath'].'Construction/';
        FileHelper::createDirectory($root);

        if ($this->validate()) {
            $this->images = array();
            foreach ($this->imageFiles as $file) {
                $path = $root.Yii::$app->security->generateRandomString().'.'. $file->extension;
                $file->saveAs($path);
                array_push($this->images, $path);
            }

            if ($this->documentFile != null) {
                $documentPath = $root . 'Documents/';
                FileHelper::createDirectory($documentPath);
                $this->document_path = $documentPath . Yii::$app->security->generateRandomString() .  '.' . $this->documentFile->extension;
                $this->documentFile->saveAs($this->document_path);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param integer $id
     * @return AdvertisingConstructionForm
     */
    public static function mapEntity($id) {
        $entity = AdvertisingConstruction::findOne($id);

        $model = new AdvertisingConstructionForm();

        $model->id = $entity->id;
        $model->name = $entity->name;
        $model->address = $entity->address;
        $model->size_id = $entity->size_id;
        $model->price = $entity->price;
        $model->type_id = $entity->type_id;
        $model->nearest_locations = $entity->nearest_locations;
        $model->traffic_info = $entity->traffic_info;
        $model->has_traffic_lights = $entity->has_traffic_lights;
        $model->is_published = $entity->is_published;
        $model->document_path = $entity->requirements_document_path;

        $model->uploaded_images = array();

        foreach ($entity->advertisingConstructionImages as $entityImage) {
            array_push($model->uploaded_images, $entityImage);
        }

        return $model;
    }

//$root = Yii::$app->params['uploadFilesPath'];
//FileHelper::createDirectory($root);
//
//$this->path = $root.$this->imageFile->baseName.'.'. $this->imageFile->extension;
//$this->imageFile->saveAs($this->path);
//return true;
}