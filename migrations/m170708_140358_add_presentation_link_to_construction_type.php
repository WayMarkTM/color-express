<?php

use yii\db\Migration;

class m170708_140358_add_presentation_link_to_construction_type extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_type', 'presentation_link', \yii\db\mysql\Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_type', 'presentation_link');
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
