<?php

use yii\db\Migration;

class m170524_023941_added_notifications extends Migration
{
    public function up()
    {
        $this->createTable('advertising_construction_notification', [
            'id' => $this->primaryKey(),
            'advertising_construction_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => \yii\db\Schema::TYPE_DATETIME.' DEFAULT NOW()',
        ]);

        $this->addForeignKey(
            'fk-advertising_construction_notification',
            'advertising_construction_notification',
            'advertising_construction_id',
            'advertising_construction',
            'id'
        );

        $this->addForeignKey(
            'fk-advertising_construction_notification_user',
            'advertising_construction_notification',
            'user_id',
            'user',
            'id'
        );
            }

    public function down()
    {
        $this->dropForeignKey('fk-advertising_construction_reservation_construction2', 'advertising_construction_reservation');

        $this->dropTable('advertising_construction_notification');

    }
}
