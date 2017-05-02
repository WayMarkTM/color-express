<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 01.05.2017
 * Time: 18:04
 */

namespace app\models;

use yii\base\Model;

class EmployeeModel extends Model
{

    public $id;
    public $name;
    public $surname;
    public $lastname;
    public $username;
    public $password;
    public $number;
    public $photo;

    function __construct($id = null, $name = null, $surname = null, $lastname = null, $login = null, $password = null, $phone = null, $photo = null) {
        parent::__construct();

        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->lastname = $lastname;
        $this->username = $login;
        $this->password = $password;
        $this->number = $phone;
        $this->photo = $photo;
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'lastname' => 'Отчество',
            'username' => 'Логин',
            'password' => 'Пароль',
            'number' => 'Телефон',
        ];
    }
}