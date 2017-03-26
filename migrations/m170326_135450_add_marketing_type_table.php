<?php

use yii\db\Migration;
use yii\db\Schema;

class m170326_135450_add_marketing_type_table extends Migration
{
    public function up()
    {
        $this->createTable('marketing_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'charge' => $this->integer(),
        ]);

        $this->insert('marketing_type', [
            'id' => 1,
            'name' => 'Белорусская реклама',
            'charge' => 0
        ]);

        $this->insert('marketing_type', [
            'id' => 2,
            'name' => 'Иностранная реклама',
            'charge' => 5
        ]);

        $this->addColumn('advertising_construction_reservation', 'marketing_type_id', SCHEMA::TYPE_INTEGER.' NULL');

        $this->addForeignKey(
            'fk_advertising_construction_reservation_marketing_type',
            'advertising_construction_reservation',
            'marketing_type_id',
            'marketing_type',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_advertising_construction_reservation_marketing_type', 'advertising_construction_reservation');
        $this->dropColumn('advertising_construction_reservation', 'marketing_type_id');
        $this->dropTable('marketing_type');
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
