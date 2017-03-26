<?php

use yii\db\Migration;
use yii\db\Schema;

class m170326_104925_add_is_available_on_external_pages_for_advertising_construction extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction', 'is_published', Schema::TYPE_BOOLEAN." DEFAULT 0");
    }

    public function down()
    {
        $this->dropColumn('advertising_construction', 'is_published');
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
