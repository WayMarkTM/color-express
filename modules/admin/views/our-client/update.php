<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\OurClient */

$this->title = 'Редактирование нашего клиента: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Управление нашими клиентами', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="our-client-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
