<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $feedBackForm app\models\FeedBackForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление вакансиями';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancy-index">

    <h3>
        <?= Html::encode($this->title) ?>
        <?= Html::a('Создать вакансию', ['create'], ['class' => 'custom-btn blue']) ?>
    </h3>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'content:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
