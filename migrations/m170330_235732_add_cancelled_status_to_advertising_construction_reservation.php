<?php

use yii\db\Migration;

class m170330_235732_add_cancelled_status_to_advertising_construction_reservation extends Migration
{
    public function up()
    {
        $this->insert('advertising_construction_reservation_status', [
            'id' => 255,
            'name' => 'Отменено'
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
