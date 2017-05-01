<?php

use yii\db\Migration;

class m170501_135252_add_is_created_by_manager_field_to_reservation extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_reservation', 'employee_id', \yii\db\mysql\Schema::TYPE_INTEGER.' NULL');
        $this->addForeignKey('fk_advertising_construction_reservation_employee', 'advertising_construction_reservation', 'employee_id', 'user', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_advertising_construction_reservation_employee', 'advertising_construction_reservation');
        $this->dropColumn('advertising_construction_reservation', 'employee_id');
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
