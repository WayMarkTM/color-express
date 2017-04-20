<?php

use yii\db\Migration;

class m170417_190202_add_subclients extends Migration
{
    public function up()
    {
        $this->createTable('subclient', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->addColumn('document', 'subclient_id', \yii\db\Schema::TYPE_INTEGER.' NULL');

        $this->addForeignKey(
            'fk-user_subclient',
            'subclient',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-subclient_document',
            'document',
            'subclient_id',
            'subclient',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-subclient_document', 'document');
        $this->dropForeignKey('fk-user_subclient', 'subclient');
        $this->dropTable('subclient');
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
