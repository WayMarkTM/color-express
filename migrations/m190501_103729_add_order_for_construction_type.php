<?php

use yii\db\Migration;

class m190501_103729_add_order_for_construction_type extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_type', 'sort_order', \yii\db\mysql\Schema::TYPE_INTEGER." NOT NULL DEFAULT 0");
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_type', 'sort_order');
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