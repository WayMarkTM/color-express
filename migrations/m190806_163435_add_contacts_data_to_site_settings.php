<?php

use yii\db\Migration;
use app\models\constants\SiteSettingKey;

class m190806_163435_add_contacts_data_to_site_settings extends Migration
{
    public function up()
    {
        $this->insert('site_settings', [
            'id' => SiteSettingKey::CONTACT_LEFT_PHONES,
            'name' => 'Номера телефонов в контактах слева (через ;)',
            'value' => '+375 (17) 399-10-96;+375 (17) 399-10-97;+375 (17) 399-10-87;+375 (17) 399-10-95'
        ]);

        $this->insert('site_settings', [
            'id' => SiteSettingKey::CONTACT_RIGHT_PHONES,
            'name' => 'Номера телефонов в контактах справа (через ;)',
            'value' => '+375 (29) 199-27-89;+375 (29) 645-04-43;+375 (29) 306-70-22;+375 (44) 742-59-21'
        ]);
    }

    public function down()
    {
        echo "m190806_163435_add_contacts_data_to_site_settings cannot be reverted.\n";

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
