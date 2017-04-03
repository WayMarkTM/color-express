<?php

use yii\db\Migration;

class m170331_004032_add_creation_date_to_advertising_construction_reservation extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_reservation', 'created_at', \yii\db\Schema::TYPE_DATETIME.' DEFAULT NOW()');
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_reservation', 'created_at');
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
