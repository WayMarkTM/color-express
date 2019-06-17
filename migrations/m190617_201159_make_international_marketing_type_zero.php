<?php

use yii\db\Migration;

class m190617_201159_make_international_marketing_type_zero extends Migration
{
    public function up()
    {
        $this->update('marketing_type', [
            'charge' => 0
        ], [
            'id' => 2,
        ]);
    }

    public function down()
    {
        $this->update('marketing_type', [
            'charge' => 5
        ], [
            'id' => 2,
        ]);
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
