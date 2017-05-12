<?php

use yii\db\Migration;

class m170512_083830_extend_bank_field_length extends Migration
{
    public function up()
    {
        $this->alterColumn('user', 'bank', 'varchar(1000) null');
        $this->alterColumn('user', 'email', 'varchar(255) null');
        $this->alterColumn('user', 'company', 'varchar(255) null');
    }

    public function down()
    {
        $this->alterColumn('user', 'bank', 'varchar(50) null');
        $this->alterColumn('user', 'email', 'varchar(20) null');
        $this->alterColumn('user', 'company', 'varchar(50) null');
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
