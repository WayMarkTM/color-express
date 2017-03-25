<?php

use yii\db\Migration;

class m170325_092450_change_advertising_construction_images_relation extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk-advertising_construction_image_file', 'advertising_construction_image');

        $this->dropColumn('advertising_construction_image', 'file_id');

        $this->addColumn('advertising_construction_image', 'path', 'string');
    }

    public function down()
    {
        $this->dropColumn('advertising_construction_image', 'path');
        $this->addColumn('advertising_construction_image', 'file_id', 'integer');
        $this->addForeignKey(
            'fk-advertising_construction_image_file',
            'advertising_construction_image',
            'file_id',
            'file',
            'id'
        );
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
