<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\PageMetadata */

$this->title = 'Обновление мета-данных: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Мета-данные о страницах', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="page-metadata-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
