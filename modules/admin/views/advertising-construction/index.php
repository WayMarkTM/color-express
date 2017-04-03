<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AdvertisingConstructionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рекламные конструкции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-index">

    <h3>
        <?= Html::encode($this->title) ?>
        <?= Html::a('Создать рекламную конструкцию', ['create'], ['class' => 'custom-btn blue']) ?>
    </h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'nearest_locations:ntext',
            'traffic_info:ntext',
            'has_traffic_lights',
            'address',
            'size.size',
            'price',
            'type.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
