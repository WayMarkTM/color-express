<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\SectionDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Содержимое секции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'custom-btn blue']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'custom-btn red',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить это содержимое секции?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'section_id',
            [
                'label' => 'Форматированный текст',
                'format' => 'raw',
                'value' => $model->formatted_text,
            ],
            'order',
            'image_path',
            'link_to',
            'link_text',
            'link_icon',
        ],
    ]) ?>

</div>
