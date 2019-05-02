<?php

use yii\db\Migration;
use app\models\constants\PageKey;

class m190502_115812_create_table_for_metadata_for_pages extends Migration
{
    public function up()
    {
        $this->createTable('page_metadata', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'title' => $this->string(1024)->notNull()->defaultValue(''),
            'description' => $this->string(4000)->notNull()->defaultValue(''),
            'keywords' => $this->string(4000)->notNull()->defaultValue(''),
        ]);

        $this->insert('page_metadata', [
            'key' => PageKey::CATALOG,
            'title' => "Каталог рекламных конструкций"
        ]);

        $this->insert('page_metadata', [
            'key' => PageKey::ADVANTAGES,
            'title' => "Преимущества"
        ]);

        $this->insert('page_metadata', [
            'key' => PageKey::ABOUT,
            'title' => "О компании"
        ]);

        $this->insert('page_metadata', [
            'key' => PageKey::OUR_CLIENTS,
            'title' => "Наши Клиенты"
        ]);

        $this->insert('page_metadata', [
            'key' => PageKey::VACANCIES,
            'title' => "Вакансии"
        ]);

        $this->insert('page_metadata', [
            'key' => PageKey::CONTACTS,
            'title' => "Контакты"
        ]);
    }

    public function down()
    {
        $this->dropTable('page_metadata');
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
