<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\Vacancy */

$this->title = 'Редактирование вакансии: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Управление вакансиями', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование вакансии';
?>
<div class="vacancy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
