<?php

namespace app\models\entities;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $password
 * @property string $salt
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
 */
class User extends ActiveRecord implements IdentityInterface
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
            [['name', 'company', 'bank'], 'string', 'max' => 50],
            [['email', 'number', 'checking_account'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [['pan', 'okpo'], 'string', 'max' => 15],
            [['photo'], 'string', 'max' => 30],
            [['username', 'password'], 'required'],
            [['name', 'bank'], 'string', 'max' => 255],
            [['username',  'name', 'is_agency',
                'company', 'address', 'pan', 'okpo', 'number',
                'checking_account', 'bank', 'photo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'sec_password' => 'Повторите пароль',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'number' => 'Телефон',
            'is_agency' => 'Тип заказчика',
            'company' => 'Название компании',
            'address' => 'Адрес',
            'pan' => 'УНП',
            'okpo' => 'ОКПО',
            'checking_account' => 'Р/С',
            'bank' => 'Банк',
            'photo' => 'Фото',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        //return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password.$this->salt, $this->password);
    }

    public function setPassword($password)
    {
        $this->salt = Yii::$app->security->generateRandomString();
        $this->password = Yii::$app->security->generatePasswordHash($password.$this->salt);
    }

    public function getRole()
    {
        return 'admin';
    }
}
