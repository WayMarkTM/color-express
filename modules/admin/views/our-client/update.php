<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\OurClient */

$this->title = 'Update Our Client: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Our Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="our-client-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
