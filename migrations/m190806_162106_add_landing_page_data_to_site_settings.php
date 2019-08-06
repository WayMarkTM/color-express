<?php

use yii\db\Migration;
use app\models\constants\SiteSettingKey;

class m190806_162106_add_landing_page_data_to_site_settings extends Migration
{
    public function up()
    {
        $this->insert('site_settings', [
            'id' => SiteSettingKey::HEADER_PHONE,
            'name' => 'Номер телефона в шапке сайт',
            'value' => '+375 (29) 199-27-89'
        ]);

        $this->insert('site_settings', [
            'id' => SiteSettingKey::FOOTER_PHONES,
            'name' => 'Номера телефона в подвале сайта (через ;)',
            'value' => '+375 (17) 399 10 96;+375 (17) 399 10 97;+375 (17) 399 10 87'
        ]);
    }

    public function down()
    {
        echo "m190806_162106_add_landing_page_data_to_site_settings cannot be reverted.\n";

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
