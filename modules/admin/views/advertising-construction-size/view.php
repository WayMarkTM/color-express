<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionSize */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Управление размерами рекламных конструкций', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-size-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'custom-btn blue']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'custom-btn red',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот размер?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'size',
        ],
    ]) ?>

</div>
