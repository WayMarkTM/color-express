<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Секции на главной';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-index">
<h3>
    <?= Html::encode($this->title) ?>
    <?= Html::a('Добавить секцию', ['create'], ['class' => 'custom-btn blue']) ?>
</h3>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type.name',
            'title',
            'order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
