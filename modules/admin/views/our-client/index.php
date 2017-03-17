<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление нашими клиентами';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="our-client-index">

    <h3>
        <?= Html::encode($this->title) ?>
        <?= Html::a('Добавить нашего клиента', ['create'], ['class' => 'custom-btn blue']) ?>
    </h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'logo_url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
