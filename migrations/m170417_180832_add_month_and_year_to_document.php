<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m170417_180832_add_month_and_year_to_document extends Migration
{
    private $table = 'document';

    public function up()
    {
        $this->addColumn($this->table, 'month', Schema::TYPE_INTEGER);
        $this->addColumn($this->table, 'year', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn($this->table, 'month');
        $this->dropColumn($this->table, 'year');
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
