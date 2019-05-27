<?php

use yii\db\Migration;

class m190526_111847_add_advertising_constrution_reservation_period_table extends Migration
{
    public function up()
    {
        $this->createTable('advertising_construction_reservation_period', [
            'id' => $this->primaryKey(),
            'advertising_construction_reservation_id' => $this->integer()->notNull(),
            'from' => $this->date()->notNull(),
            'to' => $this->date()->notNull(),
            'price' => $this->decimal(12, 2)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-reservation_period_reservation',
            'advertising_construction_reservation_period',
            'advertising_construction_reservation_id',
            'advertising_construction_reservation',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-reservation_period_reservation', 'advertising_construction_reservation_period');
        $this->dropTable('advertising_construction_reservation_period');
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
