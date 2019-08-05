<?php

use yii\db\Migration;
use app\models\constants\PageKey;

class m190730_124939_insert_page_key_index_to_page_metadata extends Migration
{
    public function up()
    {
        $this->insert('page_metadata', [
            'key' => PageKey::INDEX,
            'title' => "COLOREXPO - Размещение наружной рекламы в Минске:: Реклама на мостах, реклама на билбордах, реклама на брандмауэрах, реклама на зданиях, реклама в переходе, реклама на призматронах"
        ]);
    }

    public function down()
    {
        echo "m190730_124939_insert_page_key_index_to_page_metadata cannot be reverted.\n";

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
