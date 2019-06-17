<?php

use yii\db\Migration;

class m190617_120829_add_dismantling_to_advertising_construction extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction', 'dismantling_from', $this->date()->null());
        $this->addColumn('advertising_construction', 'dismantling_to', $this->date()->null());

    }

    public function down()
    {
        $this->dropColumn('advertising_construction', 'dismantling_to', $this->date()->null());
        $this->dropColumn('advertising_construction', 'dismantling_from', $this->date()->null());
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
