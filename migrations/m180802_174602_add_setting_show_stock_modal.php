<?php

use yii\db\Migration;

class m180802_174602_add_setting_show_stock_modal extends Migration
{
    public function up()
    {
        $this->insert('site_settings', [
            'id' => 9,
            'name' => 'Показывать блок акции',
            'value' => '1'
        ]);
    }

    public function down()
    {
        echo "m180802_174602_add_setting_show_stock_modal cannot be reverted.\n";

        return false;
    }
}
