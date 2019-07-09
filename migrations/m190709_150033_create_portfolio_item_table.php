<?php

use yii\db\Migration;

/**
 * Handles the creation of table `portfolio_item`.
 */
class m190709_150033_create_portfolio_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('portfolio_item', [
            'id' => $this->primaryKey(),
            'title' => $this->string(4000),
            'image_url' => $this->string(1000)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('portfolio_item');
    }
}
