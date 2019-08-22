<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SectionDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Содержимое секций';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-detail-index">
<h3>
    <?= Html::encode($this->title) ?>
    <?= Html::a('Добавить содержимое секции', ['create'], ['class' => 'custom-btn blue']) ?>
</h3>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'section_id',
            'order',
            'image_path',
            'link_to',
            'link_text',
            'link_icon',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
