<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-settings-index">
    <h3>
        <?= Html::encode($this->title) ?>
    </h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'value',

            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{update} {view}'
            ],
        ],
    ]); ?>
</div>
