<?php

use yii\db\Migration;

class m170405_185138_add_user_create_at extends Migration
{
    private $table = 'user';
    public function up()
    {
        $this->addColumn($this->table, 'created_at', \yii\db\Schema::TYPE_DATETIME.' DEFAULT NOW()');
    }

    public function down()
    {
        $this->dropColumn($this->table, 'created_at');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
