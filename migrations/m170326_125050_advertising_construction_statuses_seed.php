<?php

use yii\db\Migration;

class m170326_125050_advertising_construction_statuses_seed extends Migration
{
    public function up()
    {
        $this->insert('advertising_construction_reservation_status', [
            'id' => 10,
            'name' => 'В корзине (заказ)'
        ]);

        $this->insert('advertising_construction_reservation_status', [
            'id' => 11,
            'name' => 'В корзине (резерв)'
        ]);

        $this->insert('advertising_construction_reservation_status', [
            'id' => 20,
            'name' => 'В обработке'
        ]);

        $this->insert('advertising_construction_reservation_status', [
            'id' => 31,
            'name' => 'Резерв до'
        ]);

        $this->insert('advertising_construction_reservation_status', [
            'id' => 40,
            'name' => 'Подтверждено'
        ]);

        $this->insert('advertising_construction_reservation_status', [
            'id' => 50,
            'name' => 'Отклонено'
        ]);
    }

    public function down()
    {
        echo "m170326_125050_advertising_construction_statuses_seed cannot be reverted.\n";

        return false;
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
