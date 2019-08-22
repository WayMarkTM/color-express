<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carousel Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-image-index">

<h3>
    <?= Html::encode($this->title) ?>
    <?= Html::a('Добавить изображение в карусель', ['create'], ['class' => 'custom-btn blue']) ?>
</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order',
            'path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
