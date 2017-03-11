<?php

use yii\db\Migration;

class m170311_111112_fill_database_with_default_data extends Migration
{
    public function up()
    {
        $this->insert('advertising_construction_size', ['size' => '9x3']);
        $this->insert('advertising_construction_size', ['size' => '8x4']);
        $this->insert('advertising_construction_size', ['size' => '12x3']);
        $this->insert('advertising_construction_size', ['size' => '12x1,8']);
        $this->insert('advertising_construction_size', ['size' => '36x1,8']);
        $this->insert('advertising_construction_size', ['size' => '4,5x3']);
        $this->insert('advertising_construction_size', ['size' => '6x3']);
        $this->insert('advertising_construction_size', ['size' => '2x1,3']);
        $this->insert('advertising_construction_size', ['size' => '16x6']);
        $this->insert('advertising_construction_size', ['size' => '13,5x5']);

        $this->insert('advertising_construction_type', ['name' => 'Щитовые рекламные конструкции']);
        $this->insert('advertising_construction_type', ['name' => 'Брандмауэры']);
        $this->insert('advertising_construction_type', ['name' => 'Настенные световые короба']);
        $this->insert('advertising_construction_type', ['name' => 'Рекламные конструкции на путепроводах']);
        $this->insert('advertising_construction_type', ['name' => 'Надкрышные световые короба']);
        $this->insert('advertising_construction_type', ['name' => 'Рекламные конструкции в метро, переходе']);
    }

    public function down()
    {
        echo "m170311_111112_fill_database_with_default_data cannot be reverted.\n";

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
