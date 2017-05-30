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
 * @property integer $subclient_id
 * @property string $created_at
 * @property string $filename
 * @property string $contract
 *
 * @property User $user
 * @property Subclient $subclient
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
            [['created_at', 'filename'], 'safe'],
            [['path'], 'string', 'max' => 255],
            [['contract'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['subclient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subclient::className(), 'targetAttribute' => ['subclient_id' => 'id']],
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
            'contract' => 'Номер договора'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubclient()
    {
        return $this->hasOne(Subclient::className(), ['id' => 'subclient_id']);
    }
}
