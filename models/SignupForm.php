<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 14.03.2017
 * Time: 22:04
 */

namespace app\models;

use yii\base\Model;
use yii\validators\StringValidator;

class SignupForm extends Model
{
    public $user_id;

    public $username;
    public $password;
    public $sec_password;
    public $name;
    public $surname;
    public $lastname;
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
    const SCENARIO_EmployeeEditClient = 'EmployeeEditClient';
    const SCENARIO_EmployeeApplySignup = 'EmployeeApplySignup';
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CREATE_EMPLOYEE = 'CreateEmployee';
    const DEFAULT_PASS = '%;%S!@:;';

    public function rules()
    {
        return [
            [['username', 'name', 'is_agency',
                'company', 'address', 'pan', 'okpo', 'number', 'is_agency',
                'checking_account', 'bank'], 'required', 'message' => 'Поле обязательное для заполнения', 'on' => [self::SCENARIO_DEFAULT, self::SCENARIO_EmployeeEditClient]],
            [['password','sec_password'], 'string', 'min' => 8, 'tooShort' => 'Пароль слишком короткий'],
            [['sec_password'], 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            ['username', 'string', 'max' => 60],
            ['username','email', 'message' => 'email не соответствует формату'],
            [['name', 'surname', 'lastname'], 'string', 'max' => 30],
            [['company'], 'string'],
            [['number'], 'string', 'max' => 13],
            ['okpo', 'string', 'length' => 8],
            ['pan', 'string', 'length' => 9],
            ['checking_account', 'string'],
            ['bank', 'string'],
            ['username', 'validateEmail'],
            [['photo'],  'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['username', 'name', 'lastname', 'surname', 'password', 'number'], 'required', 'on' => self::SCENARIO_CREATE_EMPLOYEE],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['username', 'name', 'is_agency',
            'company', 'address', 'pan', 'okpo', 'number', 'is_agency',
            'checking_account', 'bank', 'user_id'];
        $scenarios[self::SCENARIO_EmployeeEditClient] = $scenarios[self::SCENARIO_DEFAULT];
        $scenarios[self::SCENARIO_EmployeeApplySignup] = $scenarios[self::SCENARIO_DEFAULT];
        $scenarios[self::SCENARIO_CREATE_EMPLOYEE] = ['username', 'name', 'lastname', 'surname', 'photo', 'password', 'number'];
        return $scenarios;
    }

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

    public function setUserId($id)
    {
        $this->user_id = $id;
    }

    public function validateEmail($attribute, $params)
    {
        $user = User::findByUsername($this->username);
        if($user && $user->id != $this->user_id)
            $this->addError('username', 'Этот email уже зарегистрирован');
    }
}