<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionType */

$this->title = 'Update Advertising Construction Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Advertising Construction Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="advertising-construction-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
