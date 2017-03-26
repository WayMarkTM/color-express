<?php

use yii\db\Migration;
use yii\db\Schema;

class m170326_133442_add_cost_to_reservation_model extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_reservation', 'cost', Schema::TYPE_DECIMAL);
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_reservation', 'cost');
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
