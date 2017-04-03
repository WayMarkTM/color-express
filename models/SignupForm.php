<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 14.03.2017
 * Time: 22:04
 */

namespace app\models;

use yii\base\Model;
use app\models\entities\User;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $sec_password;
    public $name;
    public $surname;
    public $email;
    public $number;
    public $is_agency;
    public $company;
    public $address;
    public $pan;
    public $okpo;
    public $checking_account;
    public $bank;
    public $photo;

    public function rules()
    {
        return [
            [['username', 'name', 'is_agency',
                'company', 'address', 'pan', 'okpo', 'number', 'is_agency',
                'checking_account', 'bank'], 'required', 'message' => 'Поле обязательное для заполнения'],
            [['password', 'sec_password'], 'required', 'message' => 'Пароль слишком короткий'],
            [['sec_password'], 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            [['username', 'password', 'name', 'is_agency',
                'company', 'address', 'pan', 'okpo', 'number',
                'checking_account', 'bank', 'photo'], 'safe'],
            ['password', 'string', 'min' => 8],
            ['username', 'string', 'max' => 60],
            ['username','email', 'message' => 'email не соответствует формату'],
            [['name', 'surname'], 'string', 'max' => 30],
            [['company'], 'string'],
            [['number'], 'string', 'max' => 13],
            ['okpo', 'string', 'length' => 8],
            ['pan', 'string', 'length' => 9],
            ['checking_account', 'string'],
            ['bank', 'string'],
            ['username', 'validateEmail'],
            [['username', 'password', 'sec_password', 'name', 'is_agency',
                'company', 'address', 'pan', 'okpo', 'number',
                'checking_account', 'bank', 'photo'], 'safe'],
        ];
    }

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
            'bank' => 'Банко',
            'photo' => 'Фото',
        ];
    }

    public function validateEmail($attribute, $params)
    {
        if(User::findByUsername($this->username))
            $this->addError('username', 'Этот email уже зарегистрирован');
    }
}