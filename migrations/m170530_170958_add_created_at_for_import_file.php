<?php

use yii\db\Migration;

class m170530_170958_add_created_at_for_import_file extends Migration
{
    public function up()
    {
        $this->addColumn('import_file', 'created_at', \yii\db\Schema::TYPE_DATETIME.' DEFAULT NOW()');
    }

    public function down()
    {
        $this->dropColumn('import_file', 'created_at');
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
