<?php

use yii\db\Migration;
use app\models\constants\PageKey;

class m190709_155132_add_portfolio_page_metadata extends Migration
{
    public function up()
    {
        $this->insert('page_metadata', [
            'key' => PageKey::PORTFOLIO,
            'title' => "Портфолио"
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
