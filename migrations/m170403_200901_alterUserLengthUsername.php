<?php

use yii\db\Migration;

class m170403_200901_alterUserLengthUsername extends Migration
{
    private $table = 'user';

    public function up()
    {
        $this->alterColumn($this->table, 'username', $this->string(255)->notNull()->unique());
    }

    public function down()
    {
    }
}
