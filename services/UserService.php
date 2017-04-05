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
use app\models\ClientModel;

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
        $clientModels= [];
        /* @param $clients User[] */
        $clients = User::find()->where(
            [
                'manage_id' => Yii::$app->user->getId()
            ]
        )->orWhere([
            'manage_id' => null,
            'is_agency' => 'not null',
        ])->orderBy('id')->all();
        foreach ($clients as $client) {
            $client_type = $client->is_agency ? 'Заказчик' : 'Агенство';
            $clientModels[] = new ClientModel($client->id, $client->company, $client->name, $client->number, $client->username, $client_type, $client->manage_id);
        }

        return $clientModels;
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