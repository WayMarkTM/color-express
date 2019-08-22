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

        $this->insert('carousel_image', [
            'order' => 1,
            'path' => '/images/external/slider-img1.png',
        ]);

        $this->insert('carousel_image', [
            'order' => 2,
            'path' => '/images/external/slider-img2.png',
        ]);

        $this->insert('carousel_image', [
            'order' => 3,
            'path' => '/images/external/slider-img3.png',
        ]);

        $this->insert('carousel_image', [
            'order' => 4,
            'path' => '/images/external/slider-img4.png',
        ]);

        $this->createTable('section_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(4000)->notNull(),
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
            'id' => 1,
            'type_id' => SectionType::TILE_2,
            'title' => '<strong>colorexpo - online платформа</strong> для покупки <br/>наружной рекламы',
            'order' => 1,
        ]);

        $this->insert('section', [
            'id' => 2,
            'type_id' => SectionType::CIRCLES,
            'title' => '<strong>colorexpo</strong> - ваш надежный партнер <br/> в наружной рекламе',
            'order' => 2,
        ]);

        $this->insert('section', [
            'id' => 3,
            'type_id' => SectionType::FREE_TEXT,
            'title' => '<strong>colorexpo - оператор наружной рекламы</strong><br/> ООО "Колорэкспресс"',
            'order' => 3,
        ]);

        $this->insert('section', [
            'id' => 4,
            'type_id' => SectionType::TILE_3,
            'title' => 'ПРЕЗЕНТАЦИИ ФОРМАТОВ РЕКЛАМНЫХ КОНСТРУКЦИЙ',
            'order' => 4,
        ]);

        $this->insert('section', [
            'id' => 5,
            'type_id' => SectionType::FREE_TEXT,
            'title' => 'НАШИ КЛИЕНТЫ И ПАРТНЕРЫ',
            'order' => 5,
        ]);

        $this->createTable('section_detail', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer()->notNull(),
            'formatted_text' => $this->string(100000)->notNull(),
            'order' => $this->integer()->notNull(),
            'image_path' => $this->string(4000)->null(),
            'link_to' => $this->string(4000)->null(),
            'link_text' => $this->string(4000)->null(),
            'link_icon' => $this->string(4000)->null()
        ]);

        $this->addForeignKey(
            'fk-section_detail_section',
            'section_detail',
            'section_id',
            'section',
            'id'
        );

        $this->insert('section_detail', [
            'section_id' => 1,
            'order' => 1,
            'image_path' => '/images/external/gal1-col1.png',
            'link_to' => '/catalog?AdvertisingConstructionSearch%5Btype_id%5D=8',
            'formatted_text' => 'реклама больших форматов на мостах и<br/>путепроводах',
        ]);
        
        $this->insert('section_detail', [
            'section_id' => 1,
            'order' => 2,
            'image_path' => '/images/external/gal1-col2.png',
            'link_to' => '/catalog?AdvertisingConstructionSearch%5Btype_id%5D=4',
            'formatted_text' => 'реклама на мостах и<br/>путепроводах',
        ]);
        
        $this->insert('section_detail', [
            'section_id' => 1,
            'order' => 3,
            'image_path' => '/images/external/gal1-col3.png',
            'link_to' => '/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1',
            'formatted_text' => 'реклама на билбордах и призматронах<br/>3*12м, 4*8м, 3*9м',
        ]);
        
        $this->insert('section_detail', [
            'section_id' => 1,
            'order' => 4,
            'image_path' => '/images/external/gal1-col4.png',
            'link_to' => '/catalog?AdvertisingConstructionSearch%5Btype_id%5D=2',
            'formatted_text' => 'РЕКЛАМА НА КРУПНОФОРМАТНЫХ<br/>БРАНДМАУЭРАХ',
        ]);
        
        $this->insert('section_detail', [
            'section_id' => 1,
            'order' => 5,
            'image_path' => '/images/external/gal1-col5.png',
            'link_to' => '/catalog?AdvertisingConstructionSearch%5Btype_id%5D=3',
            'formatted_text' => 'РЕКЛАМА НА ЗДАНИЯХ<br/>В ЦЕНТРЕ г. МИНСКА',
        ]);
        
        $this->insert('section_detail', [
            'section_id' => 1,
            'order' => 6,
            'image_path' => '/images/external/gal1-col6.png',
            'link_to' => '/catalog?AdvertisingConstructionSearch%5Btype_id%5D=6',
            'formatted_text' => 'РЕКЛАМА В ПЕРЕХОДАХ<br/>В ЦЕНТРЕ г. МИНСКА',
        ]);

        $this->insert('section_detail', [
            'section_id' => 2,
            'order' => 1,
            'image_path' => '/images/external/column-img-1.png',
            'formatted_text' => 'В вашем распоряжении <br/>рекламные поверхности в ЦЕНТРЕ города и на самых <br/>загруженных развязках и<br/>перекрестках',
        ]);

        $this->insert('section_detail', [
            'section_id' => 2,
            'order' => 2,
            'image_path' => '/images/external/column-img-2.png',
            'formatted_text' => 'Предоставим 4 000 кв.м. <br/>рекламных поверхностей <br/>для ваших маркетинговых <br/>задач ',
        ]);

        $this->insert('section_detail', [
            'section_id' => 2,
            'order' => 3,
            'image_path' => '/images/external/column-img-3.png',
            'formatted_text' => 'Оперативно подберем<br/>плоскости для решения задач <br/>вашей рекламной кампании',
        ]);

        $this->insert('section_detail', [
            'section_id' => 2,
            'order' => 4,
            'image_path' => '/images/external/column-img-4.png',
            'formatted_text' => 'Предоставим доступ к <br/>онлайн-платформе для <br/>планирования и покупки <br/>наружной рекламы, <br/>где вы сможете оперативно <br/>подобрать для себя программу <br/>любой сложности',
        ]);

        $this->insert('section_detail', [
            'section_id' => 2,
            'order' => 5,
            'image_path' => '/images/external/column-img-5.png',
            'formatted_text' => 'Обеспечим простое ценообразование',
        ]);

        $this->insert('section_detail', [
            'section_id' => 2,
            'order' => 6,
            'image_path' => '/images/external/column-img-6.png',
            'formatted_text' => 'Напечатаем рекламные <br/>материалы (при необходимости)',
        ]);

        $this->insert('section_detail', [
            'section_id' => 2,
            'order' => 7,
            'image_path' => '/images/external/column-img-7.png',
            'formatted_text' => 'Проведем еженедельный <br/>мониторинг качества <br/>рекламной поверхности<br/>и подсветки выбранной вами<br/>конструкции',
        ]);

        $this->insert('section_detail', [
            'section_id' => 2,
            'order' => 8,
            'image_path' => '/images/external/column-img-8.png',
            'formatted_text' => 'Организуем постоянную поддержку <br/>закрепленным за вашим проектом <br/>менеджером для решения <br/>всех вопросов',
        ]);

        $this->insert('section_detail', [
            'section_id' => 3,
            'formatted_text' => '<div class="col"> <p class="my-0"> <u> ООО «Колорэкспресс»</u> – один из ведущих операторов наружной рекламы, который уже более 25 лет успешно сотрудничает с белорусскими и иностранными брендами. <br><br> Компания постоянно инвестирует в развитие сети рекламных носителей, отвечающих основным требованиям, предъявляемым клиентами (размер, видимость, место), что сегодня позволяет ООО «Колорэкспресс» найти подход даже к самым требовательным клиентам. <br><br> Компания <u> ООО «Колорэкспресс»</u> предлагает размещение рекламы на МКАД и значимых улицах города Минска на собственных световых рекламных конструкциях. <br><br> В каталоге рекламных конструкций вы сможете заказать размещение наружной рекламы на: <br> </p><ul> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1&amp;AdvertisingConstructionSearch%5Bsize_id%5D=3&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0"> Биллбордах 3*12м</a>, <a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1&amp;AdvertisingConstructionSearch%5Bsize_id%5D=2&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">билбордах4*8м</a> и <a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1&amp;AdvertisingConstructionSearch%5Bsize_id%5D=1&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">призматронах 3*9м</a></li> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=8&amp;AdvertisingConstructionSearch%5Bsize_id%5D=&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0"> Рекламных конструкциях на мостах и путепроводах различных размеров</a></li> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=3&amp;AdvertisingConstructionSearch%5Bsize_id%5D=&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0"> Световых коробах на зданиях</a> в центре Минска </li> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=2&amp;AdvertisingConstructionSearch%5Bsize_id%5D=&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0"> Брандмауэрах </a></li> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=6&amp;AdvertisingConstructionSearch%5Bsize_id%5D=&amp;AdvertisingConstructionSearch%5Baddress%5D=Независимости&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">В центральном переходе г. Минска «пр-кт Независимости - ул. Ленина»</a></li> </ul> <p></p> </div> <div class="col img-info-block"><img class="img-fluid" src="/images/external/info-block-img.png" alt=""></div>',
        ]);

        $this->insert('section_detail', [
            'section_id' => 4,
            'order' => 1,
            'image_path' => '/images/external/gal2-col1.png',
            'formatted_text' => 'реклама на билбордах',
            'link_text' => 'Скачать презентацию',
            'link_to' => 'https://drive.google.com/open?id=1j-wf4RWvzZkOnfw9ZjtL6klN2k3VvD_Y',
            'link_icon' => '/images/external/pdf-icon.png',
        ]);

        $this->insert('section_detail', [
            'section_id' => 4,
            'order' => 2,
            'image_path' => '/images/external/gal2-col2.png',
            'formatted_text' => 'реклама больших<br/> форматов на мостах',
            'link_text' => 'Скачать презентацию',
            'link_to' => 'https://drive.google.com/open?id=1jacDNPsYDQcF8zGP4VS5q4T2Y6Vxi5TL',
            'link_icon' => '/images/external/pdf-icon.png',
        ]);

        $this->insert('section_detail', [
            'section_id' => 4,
            'order' => 3,
            'image_path' => '/images/external/gal2-col3.png',
            'formatted_text' => 'реклама на мостах',
            'link_text' => 'Скачать презентацию',
            'link_to' => 'https://drive.google.com/open?id=1huBwbNtLjcZegPOYrm0DPX3wIQkejvx1',
            'link_icon' => '/images/external/pdf-icon.png',
        ]);
        
        $this->insert('section_detail', [
            'section_id' => 4,
            'order' => 4,
            'image_path' => '/images/external/gal2-col4.png',
            'formatted_text' => 'реклама на брандмауэрах',
            'link_text' => 'Скачать презентацию',
            'link_to' => 'https://drive.google.com/open?id=1hsqdyLKwL_9XKbh06AH1lmVu9mJ27G3V',
            'link_icon' => '/images/external/pdf-icon.png',
        ]);
        
        $this->insert('section_detail', [
            'section_id' => 4,
            'order' => 5,
            'image_path' => '/images/external/gal2-col5.png',
            'formatted_text' => 'реклама на зданиях<br/>в центре г. Минска',
            'link_text' => 'Скачать презентацию',
            'link_to' => 'https://drive.google.com/open?id=1OGEWKo8f2D9KND0skL7BNadUOpYjAmav',
            'link_icon' => '/images/external/pdf-icon.png',
        ]);
        
        $this->insert('section_detail', [
            'section_id' => 4,
            'order' => 6,
            'image_path' => '/images/external/gal2-col6.png',
            'formatted_text' => 'реклама в переходах',
            'link_text' => 'Скачать презентацию',
            'link_to' => 'https://drive.google.com/open?id=1HX421g8tzwMrNptaMUbytdJ85ChYGrEW',
            'link_icon' => '/images/external/pdf-icon.png',
        ]);

        $this->insert('section_detail', [
            'section_id' => 5,
            'formatted_text' => '<div class="row"> <div class="col-sm-12 col-lg-6"> <hr class="line"> <img class="img-fluid" src="/images/external/partner-left.png" alt=""> </div> <div class="col-sm-12 col-lg-6"> <hr class="line"> <img class="img-fluid" src="/images/external/partner-right.png" alt=""> </div> </div>',
        ]);
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
