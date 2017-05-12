<?php

use yii\db\Migration;

class m170511_063613_change_size_of_checking_account extends Migration
{
    public function up()
    {
        $this->alterColumn('user', 'checking_account', 'varchar(28) null');
    }

    public function down()
    {
        $this->alterColumn('user', 'checking_account', 'varchar(20) null');
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
