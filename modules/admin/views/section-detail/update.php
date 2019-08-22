<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\SectionDetail */

$this->title = 'Изменение содержимого секции: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Содержимое секций', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="section-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
