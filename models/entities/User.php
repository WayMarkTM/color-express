<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $number
 * @property integer $is_agancy
 * @property string $company
 * @property string $adress
 * @property string $pan
 * @property string $okpo
 * @property string $checking_account
 * @property string $bank
 * @property string $photo
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_agancy'], 'integer'],
            [['name', 'company', 'bank'], 'string', 'max' => 50],
            [['email', 'number', 'checking_account'], 'string', 'max' => 20],
            [['adress'], 'string', 'max' => 255],
            [['pan', 'okpo'], 'string', 'max' => 15],
            [['photo'], 'string', 'max' => 30],
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
            'email' => 'Email',
            'number' => 'Number',
            'is_agancy' => 'Is Agancy',
            'company' => 'Company',
            'adress' => 'Adress',
            'pan' => 'Pan',
            'okpo' => 'Okpo',
            'checking_account' => 'Checking Account',
            'bank' => 'Bank',
            'photo' => 'Photo',
        ];
    }
}
