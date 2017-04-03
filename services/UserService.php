<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 16.03.2017
 * Time: 23:37
 */

namespace app\services;

use Yii;
use app\models\entities\User;
use app\models\SignupForm;

class UserService
{
    /* @param $signupForm SignupForm */
    public function save($signupForm)
    {
        if(!$signupForm->validate()) {
            return null;
        }
        $user = new User();
        $user->setAttributes($signupForm->getAttributes());
        $user->setPassword($signupForm->password);

        return $user->validate() && $user->save();
    }

    public function login($user)
    {
        return Yii::$app->getUser()->login($user) ? true : false;
    }

    public function getEmployeeClient()
    {
        return User::find()->where(
            [
                'manage_id' => Yii::$app->user->getId()
            ]
        )->all();
    }

    public function getNewClients()
    {
        return self::getNewClientsTemplate()->all();
    }

    public function getContNewClients()
    {
        return self::getNewClientsTemplate()->count();
    }

    private function getNewClientsTemplate()
    {
        return User::find()->where(
            [
                'is_agency' => 'not null',
                'manage_id' => 'null'
            ]);
    }
}