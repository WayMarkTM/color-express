<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\SectionDetail */

$this->title = 'Создание содержимого секции';
$this->params['breadcrumbs'][] = ['label' => 'Содержмиое секций', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
