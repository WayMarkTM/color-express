<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 11:56 PM
 */

namespace app\services;

use app\models\User;
use Yii;

class ClientsService
{
    /**
     * @param integer $managerId
     * @return array|User[]
     */
    public function getClients($managerId = null) {
        if ($managerId == null) {
            $managerId = Yii::$app->user->getId();
        }

        return User::find()
            ->where(['=', 'manage_id', $managerId])
            ->all();
    }


    /**
     * @param $id int
     * @return User
     */
    public function getClientDetails($id) {
        return User::findOne($id);
    }
}