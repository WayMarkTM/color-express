<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 23.05.2017
 * Time: 14:00
 */

namespace app\models;


use app\services\MailService;
use yii\base\Model;

class ForgotPassForm extends Model
{
    public $username;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            ['username', 'email', 'message' => 'email не соответствует формату'],
            ['username', 'validateEmail'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин'
        ];
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