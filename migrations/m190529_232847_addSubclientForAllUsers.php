<?php

use yii\db\Migration;
use app\models\User;
use app\models\entities\Document;
use app\services\SubclientService;

class m190529_232847_addSubclientForAllUsers extends Migration
{
    public function safeUp()
    {
        $users = User::find()->where(['is_agency' => '0'])->all();
        $subclientService = new SubclientService();

        foreach($users as $user) {
            $subclient = $subclientService->createSubclient(null, $user->id);

            if (!empty($subclient) && $subclient->id) {
                Document::updateAll(['subclient_id' => $subclient->id], 'user_id = '.$user->id);
            }
        }
    }

    public function safeDown()
    {
    }
}
