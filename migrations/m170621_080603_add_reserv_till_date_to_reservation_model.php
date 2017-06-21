<?php

use yii\db\Migration;

class m170621_080603_add_reserv_till_date_to_reservation_model extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_reservation', 'reserv_till', \yii\db\mysql\Schema::TYPE_DATE);
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_reservation', 'reserv_till');
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
