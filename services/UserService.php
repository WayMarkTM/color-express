<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 16.03.2017
 * Time: 23:37
 */

namespace app\services;

use app\models\entities\User;

class UserService
{
    public function save($model) {
        $user = new User();
        $user->attributes = $model;
        if($user->validate() ) {
            $user->save();
        }
    }

}