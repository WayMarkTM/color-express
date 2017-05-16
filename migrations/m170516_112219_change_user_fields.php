<?php

use yii\db\Migration;

class m170516_112219_change_user_fields extends Migration
{
    public function up()
    {
        $this->alterColumn('user', 'okpo', 'varchar(20) null');
        $this->alterColumn('user', 'number', 'varchar(1000) null');
        $this->addColumn('user', 'balance', 'decimal(10,2) null');
    }

    public function down()
    {
        $this->dropColumn('user', 'balance');
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
