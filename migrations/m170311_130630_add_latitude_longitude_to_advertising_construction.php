<?php

use yii\db\Migration;

class m170311_130630_add_latitude_longitude_to_advertising_construction extends Migration
{
    public function up()
    {
        $this->addColumn('advertising_construction', 'latitude', 'string');
        $this->addColumn('advertising_construction', 'longitude', 'string');
    }

    public function down()
    {
        $this->dropColumn('advertising_construction', 'latitude');
        $this->dropColumn('advertising_construction', 'longitude');
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
