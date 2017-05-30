<?php

namespace app\models\entities;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $name
 * @property string $surname
 * @property string $lastname
 * @property string $email
 * @property string $number
 * @property integer $is_agency
 * @property string $company
 * @property string $address
 * @property string $pan
 * @property string $okpo
 * @property string $checking_account
 * @property string $bank
 * @property string $photo
 * @property integer $manage_id
 * @property string $created_at
 * @property float $balance
 *
 * @property User $manage
 * @property User[] $users
 * @property Subclient[] $subclients
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
            [['username'], 'required'],
            [['is_agency', 'manage_id'], 'integer', 'skipOnEmpty' => true],
            [['created_at'], 'safe'],
            [['bank', 'number'], 'string', 'max' => 1000],
            [['username', 'password', 'salt', 'address', 'email', 'company'], 'string', 'max' => 255],
            [['name', 'surname'], 'string', 'max' => 50],
            [['okpo'], 'string', 'max' => 20],
            [['checking_account', 'string', 'max' => 28]],
            [['pan'], 'string', 'max' => 15],
            [['cost'], 'number'],
            [['username'], 'unique'],
            [['manage_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['manage_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'salt' => 'Salt',
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'number' => 'Number',
            'is_agency' => 'Is Agency',
            'company' => 'Company',
            'address' => 'Address',
            'pan' => 'Pan',
            'okpo' => 'Okpo',
            'checking_account' => 'Checking Account',
            'bank' => 'Bank',
            'photo' => 'Photo',
            'manage_id' => 'Manage ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManage()
    {
        return $this->hasOne(User::className(), ['id' => 'manage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['manage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubclients()
    {
        return $this->hasMany(Subclient::className(), ['user_id' => 'id']);
    }
}
