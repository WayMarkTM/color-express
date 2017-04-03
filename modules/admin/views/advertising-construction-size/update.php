<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionSize */

$this->title = 'Редактирование размера рекламных конструкций: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Управление размерами рекламных конструкций', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="advertising-construction-size-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
