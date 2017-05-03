<?php

use yii\db\Migration;

class m170503_183141_create_admin extends Migration
{
    public function up()
    {
        $user = new \app\models\User();
        $user->name = 'admin';
        $user->username = 'color_admin@gmail.com';
        $user->setPassword('colorAdmin!');
        $user->save();
        $userRole = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->assign($userRole, $user->getId());
    }

    public function down()
    {

    }
}
