<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Управление типами рекламных конструкций', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'custom-btn blue']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'custom-btn red',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот тип?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'presentation_link',
            'additional_text',
            'sort_order'
        ],
    ]) ?>

</div>
