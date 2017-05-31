<?php

use yii\db\Migration;

class m170531_002313_update_setting_of_stock extends Migration
{
    public function up()
    {
        $stock = \app\models\entities\SiteSettings::findOne(8);
        if($stock) {
            $stock->name = 'Содержимое блока "Акции" (формат - изображение; если пустое - блок не показывается)';
            $stock->save();
        }
    }

    public function down()
    {
        echo "m170531_002313_update_setting_of_stock cannot be reverted.\n";

        return false;
    }

}
