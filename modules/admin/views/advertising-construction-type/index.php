<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление типами рекламных конструкций';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-type-index">

    <h3>
        <?= Html::encode($this->title) ?>
        <?= Html::a('Создать тип рекламной конструкции', ['create'], ['class' => 'custom-btn blue']) ?>
    </h3>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'presentation_link',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
