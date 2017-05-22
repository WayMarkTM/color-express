<?php

namespace app\models;

use app\models\User;
use app\services\MailService;
use Yii;
use yii\base\Model;


class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    const FORGOT_PASSWORD = 'forgot_password';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'email', 'message' => 'email не соответствует формату', 'on' => [self::SCENARIO_DEFAULT, self::FORGOT_PASSWORD]],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['username', 'validateEmail', 'on' => [self::FORGOT_PASSWORD]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Сохранить пароль'
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DEFAULT] = ['username', 'password'];
        $scenarios[self::FORGOT_PASSWORD] = ['username'];
        return $scenarios;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Неверный логин или пароль.');
            }
        }
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$this->isValidEmail($user)) {
                $this->addError('username', 'Email не разегистрирован или не активирован.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = User::findByUsername($this->username);
            if($user && $user->isEmployee() || $user->isActiveClient()) {
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            } else {
                $this->addError('password', 'Пользователь еще не активирован.');
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        $this->_user = User::findByUsername($this->username);

        return $this->_user;
    }

    public function forgotPass()
    {
        $user = User::findByUsername($this->username);
        if($this->isValidEmail($user)) {
            $newPassword = $user->generateNewPassword();
            $mail = new MailService();

            return $mail->resetPassword($user, $newPassword);
        }

        return false;
    }

    /* @param $user User */
    private function isValidEmail($user)
    {
        $answer = false;
        if($user && ($user->isEmployee() || ($user->isClient() && $user->isActiveClient()))) {
            $answer = true;
        }

        return $answer;
    }
}
