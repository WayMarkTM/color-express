<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "client_balance".
 *
 * @property integer $id
 * @property string $company
 * @property string $pan
 * @property string $contract
 * @property string $amount
 * @property string $created_at
 * @property integer $imported_from_id
 *
 * @property ImportFile $importedFrom
 */
class ClientBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company', 'amount', 'created_at', 'imported_from_id'], 'required'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['imported_from_id'], 'integer'],
            [['company', 'pan', 'contract'], 'string', 'max' => 255],
            [['imported_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => ImportFile::className(), 'targetAttribute' => ['imported_from_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company' => 'Company',
            'pan' => 'Pan',
            'contract' => 'Contract',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'imported_from_id' => 'Imported From ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImportedFrom()
    {
        return $this->hasOne(ImportFile::className(), ['id' => 'imported_from_id']);
    }
}
