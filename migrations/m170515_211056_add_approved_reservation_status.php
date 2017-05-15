<?php

use yii\db\Migration;

class m170515_211056_add_approved_reservation_status extends Migration
{
    public function up()
    {
        $this->insert('advertising_construction_reservation_status', [
            'id' => 41,
            'name' => 'Резерв до'
        ]);
    }

    public function down()
    {

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
