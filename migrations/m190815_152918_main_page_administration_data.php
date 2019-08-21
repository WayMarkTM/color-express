<?php

use yii\db\Migration;

use app\models\constants\SectionType;

class m190815_152918_main_page_administration_data extends Migration
{
    public function up()
    {
        $this->createTable('carousel_image', [
            'id' => $this->primaryKey(),
            'order' => $this->integer()->notNull(),
            'path' => $this->string(4000)->notNull(),
        ]);

        $this->createTable('section_type', [
            'id' => $this->primaryKey(),
            'type' => $this->string(4000)->notNull(),
        ]);

        $this->insert('section_type', [
            'id' => SectionType::FREE_TEXT,
            'name' => 'Свободный формат'
        ]);

        $this->insert('section_type', [
            'id' => SectionType::CIRCLES,
            'name' => 'Круги (4 в ряд)'
        ]);

        $this->insert('section_type', [
            'id' => SectionType::TILE_2,
            'name' => 'Плитка (2 в ряд)'
        ]);

        $this->insert('section_type', [
            'id' => SectionType::TILE_3,
            'name' => 'Плитка (3 в ряд)'
        ]);

        $this->createTable('section', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'title' => $this->string(4000)->notNull(),
            'order' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-section_section_type',
            'section',
            'type_id',
            'section_type',
            'id'
        );

        $this->insert('section', [
            'type_id' => SectionType::TILE_2,
            'title' => '<strong>colorexpo - online платформа</strong> для покупки <br>наружной рекламы',
            'order' => 1,
        ]);

        $this->insert('section', [
            'type_id' => SectionType::CIRCLES,
            'title' => '<strong>colorexpo</strong> - ваш надежный партнер <br> в наружной рекламе',
            'order' => 2,
        ]);

        $this->insert('section', [
            'type_id' => SectionType::FREE_TEXT,
            'title' => '<strong>colorexpo - оператор наружной рекламы</strong><br> ООО "Колорэкспресс"',
            'order' => 3,
        ]);

        $this->insert('section', [
            'type_id' => SectionType::TILE_3,
            'title' => 'ПРЕЗЕНТАЦИИ ФОРМАТОВ РЕКЛАМНЫХ КОНСТРУКЦИЙ',
            'order' => 4,
        ]);


        $this->insert('section', [
            'type_id' => SectionType::FREE_TEXT,
            'title' => 'НАШИ КЛИЕНТЫ И ПАРТНЕРЫ',
            'order' => 5,
        ]);

        $this->createTable('section_detail', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer()->notNull(),
            'formatted_text' => $this->string(50000)->notNull(),
            'order' => $this->integer()->notNull(),
            'image_path' => $this->string(4000)->null(),
            'link_to' => $this->string(4000)->null(),
            'link_text' => $this->string(4000)->null(),
        ]);

        $this->addForeignKey(
            'fk-section_detail_section',
            'section_detail',
            'section_id',
            'section',
            'id'
        );
    }

    public function down()
    {
        echo "m190815_152918_main_page_administration_data cannot be reverted.\n";

        return false;
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
