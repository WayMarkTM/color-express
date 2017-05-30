<?php

use yii\db\Migration;

class m170529_174931_add_table_for_import extends Migration
{
    public function up()
    {
        $this->createTable('client_balance', [
            'id' => $this->primaryKey(),
            'company' => $this->string()->notNull(),
            'pan' => $this->string(),
            'contract' => $this->string(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'imported_from_id' => $this->integer()->notNull()
        ]);

        $this->createTable('import_file', [
            'id' => $this->primaryKey(),
            'filename' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-client_balance_import_file',
            'client_balance',
            'imported_from_id',
            'import_file',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-client_balance_import_file', 'client_balance');
        $this->dropTable('import_file');
        $this->dropTable('client_balance');
    }
}
