<?php

use yii\db\Migration;

class m170428_133106_set_site_settings extends Migration
{
    public function up()
    {
        $this->insert('site_settings', [
            'id' => 1,
            'name' => 'Ссылка на скачивание презентации (внешняя)',
            'value' => 'http://colorexpo.by/'
        ]);

        $this->insert('site_settings', [
            'id' => 2,
            'name' => 'Email для связи',
            'value' => 'outdoor@colorexpress.by'
        ]);

        $this->insert('site_settings', [
            'id' => 3,
            'name' => 'Номер телефонов для связи через ;',
            'value' => '+375 (29) 777 22 33;+375 (29) 777 22 33'
        ]);

        $this->insert('site_settings', [
            'id' => 4,
            'name' => 'Адрес',
            'value' => 'г. Минск, ул. Железнодорожная, 44'
        ]);

        $this->insert('site_settings', [
            'id' => 5,
            'name' => 'Адрес - координата (Latitude)',
            'value' => '53.8805047'
        ]);

        $this->insert('site_settings', [
            'id' => 6,
            'name' => 'Адрес - координата (Longitude)',
            'value' => '27.5192012'
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
