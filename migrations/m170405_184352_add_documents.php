<?php

use yii\db\Migration;

class m170405_184352_add_documents extends Migration
{
    public function up()
    {
        $this->createTable('document', [
            'id' => $this->primaryKey(),
            'path' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->addColumn('document', 'created_at', \yii\db\Schema::TYPE_DATETIME.' DEFAULT NOW()');

        $this->addForeignKey(
            'fk-user_document',
            'document',
            'user_id',
            'user',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-user_document', 'document');
        $this->dropTable('document');
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
