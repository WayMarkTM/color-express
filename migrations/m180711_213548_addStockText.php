<?php

use yii\db\Migration;

class m180711_213548_addStockText extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction', 'stock_text', \yii\db\mysql\Schema::TYPE_STRING." NOT NULL DEFAULT 'Акция'");
    }

    public function down()
    {
        $this->dropColumn('advertising_construction', 'stock_text');
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
