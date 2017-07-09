<?php

use yii\db\Migration;

class m170709_113105_add_comment_to_reservation extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction_reservation', 'comment', \yii\db\mysql\Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_reservation', 'comment');
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
