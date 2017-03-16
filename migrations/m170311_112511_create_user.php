<?php

use yii\db\Migration;

class m170311_112511_create_user extends Migration
{
    private $table = 'user';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'username' => $this->string(15),
            'password' => $this->string(),
            'salt' => $this->string(),
            'name' => $this->string(50),
            'surname' => $this->string(50),
            'email' => $this->string(20),
            'number' => $this->string(20),
            'is_agency' => $this->boolean(),
            'company' => $this->string(50),
            'adress' => $this->string(),
            'pan' => $this->string(15),
            'okpo' => $this->string(15),
            'checking_account' => $this->string(20),
            'bank' => $this->string(50),
            'photo' => $this->string(30)
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
