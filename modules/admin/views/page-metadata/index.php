<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мета-данные о страницах';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-metadata-index">
    <h1><?= Html::encode($this->title) ?></h1>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'key',
            'title',
            'description',
            'keywords',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
