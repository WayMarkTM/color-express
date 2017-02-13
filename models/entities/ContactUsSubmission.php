<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "contact_us_submission".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property integer $cv_id
 * @property string $message
 * @property string $submitted_at
 *
 * @property File $cv
 */
class ContactUsSubmission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_us_submission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cv_id'], 'integer'],
            [['message'], 'string'],
            [['submitted_at'], 'safe'],
            [['name', 'phone', 'email'], 'string', 'max' => 255],
            [['cv_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['cv_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'cv_id' => 'Cv ID',
            'message' => 'Message',
            'submitted_at' => 'Submitted At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCv()
    {
        return $this->hasOne(File::className(), ['id' => 'cv_id']);
    }
}
