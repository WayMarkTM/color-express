<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\CarouselImage */

$this->title = 'Изменение изображения в карусели: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Изображения в карусели', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="carousel-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
