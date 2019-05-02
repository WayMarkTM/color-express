<?php

use yii\db\Migration;

class m190501_095000_add_textbox_for_construction_type extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_type', 'additional_text', "varchar(4000) NOT NULL DEFAULT ''");
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_type', 'additional_text');
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
