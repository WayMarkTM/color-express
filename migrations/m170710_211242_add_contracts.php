<?php

use yii\db\Migration;

class m170710_211242_add_contracts extends Migration
{
    public function up()
    {
        $this->createTable('contract', [
            'id' => $this->primaryKey(),
            'path' => $this->string()->notNull(),
            'filename' => $this->string()->notNull(),
            'year' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'subclient_id' => $this->integer()->null()
        ]);

        $this->addColumn('contract', 'created_at', \yii\db\Schema::TYPE_DATETIME.' DEFAULT NOW()');

        $this->addForeignKey(
            'fk-user_contract',
            'contract',
            'user_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-subclient_contract',
            'contract',
            'subclient_id',
            'subclient',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-subclient_contract', 'contract');
        $this->dropForeignKey('fk-user_contract', 'contract');
        $this->dropTable('contract');
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
