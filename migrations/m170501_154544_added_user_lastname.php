<?php

use yii\db\Migration;

class m170501_154544_added_user_lastname extends Migration
{
    private $table = 'user';
    public function up()
    {
        $this->addColumn($this->table, 'lastname', 'varchar(50)');
    }

    public function down()
    {
        $this->dropColumn($this->table, 'lastname');
    }

}
