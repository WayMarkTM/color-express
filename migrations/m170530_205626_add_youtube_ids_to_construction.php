<?php

use yii\db\Migration;

class m170530_205626_add_youtube_ids_to_construction extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction', 'youtube_ids', 'varchar(10000) null');
    }

    public function down()
    {
        $this->dropColumn('advertising_construction', 'youtube_ids');
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
