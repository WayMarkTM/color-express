<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionSize */

$this->title = 'Update Advertising Construction Size: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Advertising Construction Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="advertising-construction-size-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
