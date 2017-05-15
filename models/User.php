<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 05.04.2017
 * Time: 22:50
 */

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\web\UploadedFile;

class User extends entities\User implements IdentityInterface
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['is_agency', 'manage_id'], 'integer'],
            [['created_at'], 'safe'],
            [['username', 'password', 'salt', 'address', 'email', 'company'], 'string', 'max' => 255],
            [['name', 'surname'], 'string', 'max' => 50],
            [['bank'], 'string'],
            [['checking_account'], 'string', 'max' => 28],
            [['number'], 'string', 'max' => 20],
            [['pan', 'okpo'], 'string', 'max' => 15],
            [['photo'],  'string', 'max' => 255],
            [['username'], 'unique'],
            [['manage_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['manage_id' => 'id']],
            [['username',  'name', 'is_agency',
                'company', 'address', 'pan', 'okpo', 'number',
                'checking_account', 'bank', 'surname', 'lastname'], 'safe'],
            ['password', 'safe']
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
            'lastname' => 'Отчество',
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
        $roles = Yii::$app->authManager->getRolesByUser($this->getId());
        $role = current($roles);
        
        return $role->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->is_agency ? 'Агенство' : 'Заказчик';
    }

    public function isEmployee()
    {
        return $this->is_agency == null;
    }

    public function isClient()
    {
        return $this->is_agency !== null;
    }

    public function isActiveClient()
    {
        return $this->is_agency != null && $this->manage_id != null;
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if(array_key_exists( 'password', $values)) {
            unset($values['password']);
        }
        if(array_key_exists( 'photo', $values)) {
            unset($values['photo']);
        }
        parent::setAttributes($values, $safeOnly); // TODO: Change the autogenerated stub
    }

    public function getDisplayName()
    {
        return $this->name.' '.$this->surname;
    }

    public function upload()
    {
        if($this->imageFile) {
            $root = Yii::$app->params['uploadFilesPath'] . 'employee/';
            FileHelper::createDirectory($root);

            $this->photo = $root . Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
            return $this->imageFile->saveAs($this->photo);
        }
    }

}