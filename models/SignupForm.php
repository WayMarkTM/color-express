<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 14.03.2017
 * Time: 22:04
 */

namespace app\models;
use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $sec_password;
    public $name;
    public $surname;
    public $salt;
    public $email;
    public $number;
    public $is_agency;
    public $company;
    public $adress;
    public $pan;
    public $okpo;
    public $checking_account;
    public $bank;
    public $photo;

    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
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
}