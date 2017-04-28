<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m170428_131909_add_name_to_site_settings extends Migration
{
    private $table = 'site_settings';

    public function up()
    {
        $this->addColumn($this->table, 'name', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn($this->table, 'name');
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
