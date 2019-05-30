<?php

namespace app\helpers;

use app\models\User;
use Yii;


class Helpers
{
    /**
     * @return bool
     */
    static function isEmployee() {
        $role = User::findIdentity(Yii::$app->user->getId())->getRole();
        return $role == 'employee';
    }
}

?>