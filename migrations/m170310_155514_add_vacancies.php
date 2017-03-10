<?php

use yii\db\Migration;

class m170310_155514_add_vacancies extends Migration
{
    public function up()
    {
        $this->createTable('vacancy', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('vacancy');
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
