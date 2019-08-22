<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\CarouselImage */

$this->title = 'Create Carousel Image';
$this->params['breadcrumbs'][] = ['label' => 'Carousel Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
