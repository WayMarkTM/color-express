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
        $clients = User::find();
        if ($managerId) {
            $clients->andWhere(['manage_id' => $managerId]);
        }
        return $clients->all();
    }


    /**
     * @param $id int
     * @return User
     */
    public function getClientDetails($id) {
        return User::findOne($id);
    }
}