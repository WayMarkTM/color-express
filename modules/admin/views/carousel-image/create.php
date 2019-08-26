<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\CarouselImage */

$this->title = 'Добавить изображение в карусель';
$this->params['breadcrumbs'][] = ['label' => 'Изображения в карусели', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
