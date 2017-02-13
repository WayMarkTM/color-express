<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $path
 * @property string $uploaded_at
 *
 * @property AdvertisingConstructionImage[] $advertisingConstructionImages
 * @property ContactUsSubmission[] $contactUsSubmissions
 * @property UserDocument[] $userDocuments
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'uploaded_at'], 'required'],
            [['uploaded_at'], 'safe'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'uploaded_at' => 'Uploaded At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingConstructionImages()
    {
        return $this->hasMany(AdvertisingConstructionImage::className(), ['file_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactUsSubmissions()
    {
        return $this->hasMany(ContactUsSubmission::className(), ['cv_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDocuments()
    {
        return $this->hasMany(UserDocument::className(), ['file_id' => 'id']);
    }
}
