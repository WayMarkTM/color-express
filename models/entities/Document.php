<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property integer $id
 * @property string $path
 * @property integer $user_id
 * @property integer $month
 * @property integer $year
 * @property string $created_at
 *
 * @property User $user
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'user_id', 'month', 'year'], 'required'],
            [['user_id', 'month', 'year'], 'integer'],
            [['created_at'], 'safe'],
            [['path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
