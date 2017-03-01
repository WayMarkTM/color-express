<?php

use yii\db\Migration;

class m170301_121052_add_our_clients extends Migration
{
    public function up()
    {
        $this->createTable('our_client', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'logo_url' => $this->string()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('our_client');
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
