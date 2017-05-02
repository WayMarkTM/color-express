<?php

use yii\db\Migration;

class m170502_143904_photo_more_length extends Migration
{
    private $table = 'user';

    public function up()
    {
        $this->alterColumn($this->table, 'photo', 'varchar(255)');
    }

    public function down()
    {
    }
}
