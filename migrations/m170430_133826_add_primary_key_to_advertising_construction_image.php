<?php

use yii\db\Migration;

class m170430_133826_add_primary_key_to_advertising_construction_image extends Migration
{
    public function up()
    {
        $this->addColumn(
            'advertising_construction_image',
            'id',
            'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT primary key FIRST'
        );
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_image', 'id');
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
