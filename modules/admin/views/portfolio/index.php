<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Записи в портфолио';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portfolio-item-index">
<h3>
    <?= Html::encode($this->title) ?>
    <?= Html::a('Добавить запись в портфолио', ['create'], ['class' => 'custom-btn blue']) ?>
</h3>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'image_url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
