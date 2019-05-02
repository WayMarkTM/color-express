<?php

use yii\db\Migration;

class m190502_111735_add_instagram_facebook_site_settings extends Migration
{
    public function up()
    {
        $this->insert('site_settings', [
            'id' => 10,
            'name' => 'Ссылка на Instagram',
            'value' => 'https://www.instagram.com/colorexpress_minsk/'
        ]);

        $this->insert('site_settings', [
            'id' => 11,
            'name' => 'Ссылка на Facebook',
            'value' => 'https://web.facebook.com/ColorExpo.BY'
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
