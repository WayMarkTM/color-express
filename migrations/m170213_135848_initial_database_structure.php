<?php

use yii\db\Migration;
use yii\db\Schema;

class m170213_135848_initial_database_structure extends Migration
{
    public function up()
    {
        $this->createTable('contact_us_submission', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'cv_id' => $this->integer(),
            'message' => $this->text(),
            'submitted_at' => $this->datetime()
        ]);

        $this->createTable('advertising_construction_reservation_status', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->createTable('advertising_construction_size', [
            'id' => $this->primaryKey(),
            'size' => $this->string()
        ]);

        $this->createTable('advertising_construction_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->createTable('advertising_construction_reservation', [
            'id' => $this->primaryKey(),
            'advertising_construction_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'from' => $this->date()->notNull(),
            'to' => $this->date()->notNull()
        ]);

        $this->createTable('advertising_construction', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'nearest_locations' => $this->text(),
            'traffic_info' => $this->text(),
            'has_traffic_lights' => $this->boolean(),
            'address' => $this->string()->notNull(),
            'size_id' => $this->integer()->notNull(),
            'price' => $this->decimal()->notNull(),
            'type_id' => $this->integer()->notNull()
        ]);

        $this->createTable('file', [
            'id' => $this->primaryKey(),
            'path' => $this->string()->notNull(),
            'uploaded_at' => $this->datetime()->notNull()
        ]);

        $this->createTable('advertising_construction_image', [
            'advertising_construction_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull()
        ]);

        $this->createTable('user_document', [
            'user_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull()
        ]);


        $this->addForeignKey(
            'fk-advertising_construction_size',
            'advertising_construction',
            'size_id',
            'advertising_construction_size',
            'id'
        );

        $this->addForeignKey(
            'fk-advertising_construction_type',
            'advertising_construction',
            'type_id',
            'advertising_construction_type',
            'id'
        );

        $this->addForeignKey(
            'fk-advertising_construction_reservation_construction',
            'advertising_construction_reservation',
            'advertising_construction_id',
            'advertising_construction',
            'id'
        );

        $this->addForeignKey(
            'fk-advertising_construction_reservation_status',
            'advertising_construction_reservation',
            'status_id',
            'advertising_construction_reservation_status',
            'id'
        );

        $this->addForeignKey(
            'fk-contact_us_submission_file',
            'contact_us_submission',
            'cv_id',
            'file',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-advertising_construction_image_construction',
            'advertising_construction_image',
            'advertising_construction_id',
            'advertising_construction',
            'id'
        );

        $this->addForeignKey(
            'fk-advertising_construction_image_file',
            'advertising_construction_image',
            'file_id',
            'file',
            'id'
        );

        $this->addForeignKey(
            'fk-user_document_file',
            'user_document',
            'file_id',
            'file',
            'id'
        );

        $this->createIndex(
            'idx-advertising_construction_size',
            'advertising_construction',
            'size_id'
        );

        $this->createIndex(
            'idx-advertising_construction_type',
            'advertising_construction',
            'type_id'
        );

        $this->createIndex(
            'idx-advertising_construction_reservation_user',
            'advertising_construction_reservation',
            'user_id'
        );


        $this->createIndex(
            'idx-advertising_construction_reservation_status',
            'advertising_construction_reservation',
            'status_id'
        );
    }

    public function down()
    {
        $this->dropIndex('idx-advertising_construction_reservation_status', 'advertising_construction_reservation');
        $this->dropIndex('idx-advertising_construction_reservation_user', 'advertising_construction_reservation');
        $this->dropIndex('idx-advertising_construction_type', 'advertising_construction');
        $this->dropIndex('idx-advertising_construction_size', 'advertising_construction');

        $this->dropForeignKey('fk-user_document_file', 'user_document');
        $this->dropForeignKey('fk-advertising_construction_image_file', 'advertising_construction_image');
        $this->dropForeignKey('fk-advertising_construction_image_construction', 'advertising_construction_image');
        $this->dropForeignKey('fk-contact_us_submission_file', 'contact_us_submission');
        $this->dropForeignKey('fk-advertising_construction_reservation_status', 'advertising_construction_reservation');
        $this->dropForeignKey('fk-advertising_construction_reservation_construction', 'advertising_construction_reservation');
        $this->dropForeignKey('fk-advertising_construction_type', 'advertising_construction');
        $this->dropForeignKey('fk-advertising_construction_size', 'advertising_construction');

        $this->dropTable('user_document');
        $this->dropTable('advertising_construction_image');
        $this->dropTable('file');
        $this->dropTable('advertising_construction');
        $this->dropTable('advertising_construction_reservation');
        $this->dropTable('advertising_construction_type');
        $this->dropTable('advertising_construction_size');
        $this->dropTable('advertising_construction_reservation_status');
        $this->dropTable('contact_us_submission');
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
