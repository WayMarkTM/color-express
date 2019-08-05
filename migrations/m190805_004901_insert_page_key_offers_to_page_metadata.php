<?php

use yii\db\Migration;
use app\models\constants\PageKey;

class m190805_004901_insert_page_key_offers_to_page_metadata extends Migration
{
    public function up()
    {
        $this->insert('page_metadata', [
            'key' => PageKey::OFFERS,
            'title' => ""
        ]);
    }

    public function down()
    {
        echo "m190805_004901_insert_page_key_offers_to_page_metadata cannot be reverted.\n";

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
