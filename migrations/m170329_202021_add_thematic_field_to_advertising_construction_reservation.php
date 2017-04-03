<?php

use yii\db\Migration;

class m170329_202021_add_thematic_field_to_advertising_construction_reservation extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_reservation', 'thematic', \yii\db\Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_reservation', 'thematic');
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
