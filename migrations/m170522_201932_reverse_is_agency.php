<?php

use yii\db\Migration;

class m170522_201932_reverse_is_agency extends Migration
{
    public function up()
    {
        $users = \app\models\User::find()->where(['OR', ['is_agency' => '0'], ['is_agency' => '1']])->all();
        foreach($users as $user) {
            if($user->isClient()) {
                $user->is_agency = $user->is_agency ? 0 : 1;
                $user->save();
            }
        }
    }

    public function down()
    {
    }

}
