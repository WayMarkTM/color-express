<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 16.03.2017
 * Time: 23:37
 */

namespace app\services;

use Yii;
use app\models\User;
use app\models\SignupForm;
use app\models\ClientModel;
use app\models\RegistrationRequestModel;

class UserService
{
    /* @param $signupForm SignupForm */
    public function save($signupForm, $user_id = null)
    {
        if(!$signupForm->validate()) {
            return null;
        }

        $user = null;
        if($user_id) {
            $user = User::findIdentity($user_id);
        }

        if(!$user_id && !$user) {
            $user = new User();
        }

        $user->setAttributes($signupForm->getAttributes());

        if($signupForm->password != $signupForm::DEFAULT_PASS ) {
            $user->setPassword($signupForm->password);
        }

        return $user->validate() && $user->save();
    }

    public function login($user)
    {
        return Yii::$app->getUser()->login($user) ? true : false;
    }

    public function getEmployeeClient()
    {
        $clientModels= [];
        /* @param $clients User[] */
        $clients = User::find()->where(
            [
                'OR',
                [
                    'manage_id' => Yii::$app->user->getId(),

                ],
                [
                    'AND',
                    ['NOT', ['is_agency' => null]],
                    ['manage_id' => null]
                ]

            ]
        )->orderBy('id')->all();
        foreach ($clients as $client) {
            $client_type = $client->is_agency ? 'Заказчик' : 'Агенство';
            $manager = $client->manage ? $client->manage->name.' '.$client->manage->surname : '';
            $clientModels[] = new ClientModel($client->id, $client->company, $client->name, $client->number, $client->username, $client_type, $manager);
        }

        return $clientModels;
    }

    public function getNewClients()
    {
        $clientModels= [];
        $newClients = self::getNewClientsTemplate()->orderBy('id')->all();
        foreach ($newClients as $client) {
            $client_type = $client->is_agency ? 'Заказчик' : 'Агенство';
            $clientModels[] = new RegistrationRequestModel($client->id, $client->company, new \DateTime($client->created_at), $client_type);
        }

        return $clientModels;

    }

    public static function getContNewClients()
    {
        return self::getNewClientsTemplate()->count();
    }

    private function getNewClientsTemplate()
    {
        return User::find()->where(
            [
                'AND',
                [
                    'NOT',
                    [
                        'is_agency' => null
                    ]
                ],
                [
                    'manage_id' => null
                ]
            ]);
    }

    public function setActiveUser($id)
    {
        $user = User::findIdentity($id);
        if($user && !$user->isActiveClient()) {
            $user->manage_id = \Yii::$app->user->getId();
            if($user->save()) {
                //set email
            }
        }
    }

    public function deleteClient($id)
    {
        $user = User::findIdentity($id);
        if($user && $user->isClient()) {
            $user->delete();
        }
    }

    public function getClientById($id)
    {
        $user = User::findIdentity($id);

        return $user;
    }

    /** @param $signupForm SignupForm */
    public function setUserToSignUpForm($signupForm, $id)
    {
        $user = User::findIdentity($id);
        if($user) {
            $signupForm->setAttributes($user->getAttributes());
            $signupForm->setUserId($user->id);
            $signupForm->password = $signupForm::DEFAULT_PASS;
            $signupForm->sec_password = $signupForm::DEFAULT_PASS;
        }
        return $signupForm;
    }

}