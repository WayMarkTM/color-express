<?php

use yii\db\Migration;
use app\models\constants\SectionType;

class m190902_112751_add_text_with_image_section_type extends Migration
{
    public function up()
    {
        $this->insert('section_type', [
            'id' => SectionType::FREE_TEXT_WITH_IMAGE,
            'name' => 'Свободный текст и изображение'
        ]);

        $this->update('section', [
            'type_id' =>  SectionType::FREE_TEXT_WITH_IMAGE,
        ], [
            'id' => 3
        ]);

        $this->update('section_detail', [
            'image_path' => '/images/external/info-block-img.png',
            'formatted_text' => '<p class="my-0"> <u> ООО «Колорэкспресс»</u> – один из ведущих операторов наружной рекламы, который уже более 25 лет успешно сотрудничает с белорусскими и иностранными брендами. <br><br> Компания постоянно инвестирует в развитие сети рекламных носителей, отвечающих основным требованиям, предъявляемым клиентами (размер, видимость, место), что сегодня позволяет ООО «Колорэкспресс» найти подход даже к самым требовательным клиентам. <br><br> Компания <u> ООО «Колорэкспресс»</u> предлагает размещение рекламы на МКАД и значимых улицах города Минска на собственных световых рекламных конструкциях. <br><br> В каталоге рекламных конструкций вы сможете заказать размещение наружной рекламы на: <br> </p><ul> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1&amp;AdvertisingConstructionSearch%5Bsize_id%5D=3&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0"> Биллбордах 3*12м</a>, <a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1&amp;AdvertisingConstructionSearch%5Bsize_id%5D=2&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">билбордах4*8м</a> и <a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1&amp;AdvertisingConstructionSearch%5Bsize_id%5D=1&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">призматронах 3*9м</a></li> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=8&amp;AdvertisingConstructionSearch%5Bsize_id%5D=&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0"> Рекламных конструкциях на мостах и путепроводах различных размеров</a></li> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=3&amp;AdvertisingConstructionSearch%5Bsize_id%5D=&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0"> Световых коробах на зданиях</a> в центре Минска </li> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=2&amp;AdvertisingConstructionSearch%5Bsize_id%5D=&amp;AdvertisingConstructionSearch%5Baddress%5D=&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0"> Брандмауэрах </a></li> <li><a href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=6&amp;AdvertisingConstructionSearch%5Bsize_id%5D=&amp;AdvertisingConstructionSearch%5Baddress%5D=Независимости&amp;AdvertisingConstructionSearch%5BfromDate%5D=&amp;AdvertisingConstructionSearch%5BtoDate%5D=&amp;AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">В центральном переходе г. Минска «пр-кт Независимости - ул. Ленина»</a></li> </ul> <p></p>'
        ], [
            'section_id' => 3
        ]);
    }

    public function down()
    {
        echo "m190902_112751_add_text_with_image_section_type cannot be reverted.\n";

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
