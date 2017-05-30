<?php

use yii\db\Migration;

class m170530_191033_update_subclients extends Migration
{
    public function up()
    {
        $this->addColumn('document', 'contract', \yii\db\mysql\Schema::TYPE_STRING);

        $this->addColumn('subclient', 'balance', 'decimal(10,2) null');
    }

    public function down()
    {
        $this->dropColumn('document', 'contract');
        $this->dropColumn('subclient', 'balance');
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
