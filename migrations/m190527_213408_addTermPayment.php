<?php

use yii\db\Migration;

class m190527_213408_addTermPayment extends Migration
{
    public function up()
    {
        $this->addColumn('subclient', 'term_payment', \yii\db\mysql\Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('subclient', 'term_payment');
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
