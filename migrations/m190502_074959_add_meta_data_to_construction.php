<?php

use yii\db\Migration;

class m190502_074959_add_meta_data_to_construction extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction', 'meta_title', "varchar(1024) NOT NULL DEFAULT ''");
        $this->addColumn('advertising_construction', 'meta_description', "varchar(4000) NOT NULL DEFAULT ''");
        $this->addColumn('advertising_construction', 'meta_keywords', "varchar(4000) NOT NULL DEFAULT ''");
    }

    public function down()
    {
        $this->dropColumn('advertising_construction', 'meta_keywords');
        $this->dropColumn('advertising_construction', 'meta_description');
        $this->dropColumn('advertising_construction', 'meta_title');
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
