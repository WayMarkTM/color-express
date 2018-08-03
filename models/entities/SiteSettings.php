<?php

namespace app\models\entities;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "site_settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class SiteSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'name'], 'required'],
            [['value', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Описание',
            'value' => 'Значение'
        ];
    }

    public function isImage()
    {
        return $this->id == 8;
    }

    public function isCheckbox()
    {
        return $this->id == 9;
    }

    /* @param $imageFile UploadedFile */
    public function upload($imageFile)
    {
        if (!empty($imageFile)) {
            $root = Yii::$app->params['uploadFilesPath'] . 'stock/';
            FileHelper::createDirectory($root);

            $this->value = $root . Yii::$app->security->generateRandomString() . '.' . $imageFile->extension;
            return $imageFile->saveAs($this->value);
        }
    }
}
