<?php

use yii\db\Migration;

class m190827_115938_create_table_for_exclusive_offer extends Migration
{
    public function up()
    {
        $this->createTable('exclusive_offer_page', [
            'id' => $this->primaryKey(),
            'formatted_text' => $this->string(500000)->notNull(),
            'image_path' => $this->string(4000)->notNull(),
            'title' => $this->string(5000)->notNull(),
            'facebook_title' => $this->string(5000)->notNull(),
        ]);

        $this->insert('exclusive_offer_page', [
            'id' => 1,
            'formatted_text' => '<p><strong>Уважаемые партнеры!</strong></p> <p>Компания ООО "Колорэкспресс" запускает программу лояльности "Удачное размещение" для своих клиентов, которая позволит сэкономить рекламный бюджет до 50%.</p> <p>20-ого числа каждого месяца мы будем отправлять Вам список рекламных конструкций, доступных к бронированию по специальным ценам в рамках программы "Удачное размещение".</p> <p><a class="text-body underlined-link" href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1&AdvertisingConstructionSearch%5Bsize_id%5D=3&AdvertisingConstructionSearch%5Baddress%5D=&AdvertisingConstructionSearch%5BfromDate%5D=&AdvertisingConstructionSearch%5BtoDate%5D=&AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">Билборды 3*12м</a> и <a class="text-body underlined-link" href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=3&AdvertisingConstructionSearch%5Bsize_id%5D=6&AdvertisingConstructionSearch%5Baddress%5D=&AdvertisingConstructionSearch%5BfromDate%5D=&AdvertisingConstructionSearch%5BtoDate%5D=&AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">световые короба 3*4,5м</a> по проспекту Независимости, <a class="text-body underlined-link" href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=1&AdvertisingConstructionSearch%5Bsize_id%5D=1&AdvertisingConstructionSearch%5Baddress%5D=&AdvertisingConstructionSearch%5BfromDate%5D=&AdvertisingConstructionSearch%5BtoDate%5D=&AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">призматроны 3*9м</a> и <a class="text-body underlined-link" href="/catalog?AdvertisingConstructionSearch%5Btype_id%5D=4&AdvertisingConstructionSearch%5Bsize_id%5D=4&AdvertisingConstructionSearch%5Baddress%5D=&AdvertisingConstructionSearch%5BfromDate%5D=&AdvertisingConstructionSearch%5BtoDate%5D=&AdvertisingConstructionSearch%5BshowOnlyFreeConstructions%5D=0">рекламные конструкциии 1,8*12м на мостах</a> в г. Минске по отличным ценам.</p> <p>Становитесь участником программы лояльности "Удачное размещение" и бронируйте конструкции на сайте colorexpo.by, либо у наших менеджеров +375 (17) 399-10-96/97.</p>',
            'image_path' => '/images/external/ex-of-img.png',
            'title' => 'Программа Лояльности "Удачное размещение"',
            'facebook_title' => 'Программа Лояльности Удачное размещение',
        ]);
    }

    public function down()
    {
        echo "m190827_115938_create_table_for_exclusive_offer cannot be reverted.\n";

        return true;
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
