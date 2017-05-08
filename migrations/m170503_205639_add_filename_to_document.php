<?php

use yii\db\Migration;

class m170503_205639_add_filename_to_document extends Migration
{
    public function up()
    {
        $this->addColumn('document', 'filename', \yii\db\mysql\Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('document', 'filename');
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
