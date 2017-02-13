<?php

use yii\db\Migration;
use yii\db\Schema;

class m170213_121426_initial_migration extends Migration
{
    public function up()
    {
        $this->createTable('site_settings', [
            'id' => $this->primaryKey(),
            'value' => $this->string()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('site_settings');
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
