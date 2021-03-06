<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstruction */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Управление рекламными конструкциями', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'custom-btn blue']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'custom-btn red',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту рекламную конструкцию??',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'nearest_locations:ntext',
            'traffic_info:ntext',
            'has_traffic_lights',
            'address',
            'latitude',
            'longitude',
            'size.size',
            'price',
            'type.name',
            'requirements_document_path',
            'has_stock',
            'is_published',
            'youtube_ids'
        ],
    ]) ?>

    <?php
    if (count($model->advertisingConstructionImages) > 0) { ?>
        <div class="row block-row">
            <label class="control-label col-sm-12">Загруженные изображения</label>
        </div>
    <?php
        foreach ($model->advertisingConstructionImages as $image) { ?>
            <div class="advertising-construction-image-preview">
                <div class="image">
                    <img src="/<?php echo $image->path; ?>"/>
                </div>
            </div>
    <?php }
        }?>
</div>
