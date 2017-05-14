<?php

use yii\db\Migration;

class m170514_133554_update_cost_format extends Migration
{
    public function up()
    {
        $this->alterColumn('advertising_construction', 'price', 'decimal(10,2)');
        $this->alterColumn('advertising_construction_reservation', 'cost', 'decimal(10,2)');
    }

    public function down()
    {
        $this->alterColumn('advertising_construction', 'price', 'decimal(10,0)');
        $this->alterColumn('advertising_construction_reservation', 'cost', 'decimal(10,0)');
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
