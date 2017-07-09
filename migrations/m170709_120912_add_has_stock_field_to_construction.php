<?php

use yii\db\Migration;

class m170709_120912_add_has_stock_field_to_construction extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction', 'has_stock', \yii\db\mysql\Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('advertising_construction', 'has_stock');
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
