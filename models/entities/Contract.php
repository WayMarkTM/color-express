<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "contract".
 *
 * @property integer $id
 * @property string $path
 * @property string $filename
 * @property integer $year
 * @property integer $user_id
 * @property integer $subclient_id
 * @property string $created_at
 *
 * @property Subclient $subclient
 * @property User $user
 */
class Contract extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contract';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'filename', 'year', 'user_id'], 'required'],
            [['year', 'user_id', 'subclient_id'], 'integer'],
            [['created_at'], 'safe'],
            [['path', 'filename'], 'string', 'max' => 255],
            [['subclient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subclient::className(), 'targetAttribute' => ['subclient_id' => 'id']],
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
            'filename' => 'Filename',
            'year' => 'Year',
            'user_id' => 'User ID',
            'subclient_id' => 'Subclient ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubclient()
    {
        return $this->hasOne(Subclient::className(), ['id' => 'subclient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
