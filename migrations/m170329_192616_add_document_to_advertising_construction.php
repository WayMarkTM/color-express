<?php

use yii\db\Migration;

class m170329_192616_add_document_to_advertising_construction extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction', 'requirements_document_path', \yii\db\Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('advertising_construction', 'requirements_document_path');
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
