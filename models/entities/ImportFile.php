<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "import_file".
 *
 * @property integer $id
 * @property string $filename
 * @property integer $status
 *
 * @property ClientBalance[] $clientBalances
 */
class ImportFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename', 'status'], 'required'],
            [['status'], 'integer'],
            [['filename'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientBalances()
    {
        return $this->hasMany(ClientBalance::className(), ['imported_from_id' => 'id']);
    }
}
