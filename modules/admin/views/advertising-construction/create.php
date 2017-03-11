<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstruction */

$this->title = 'Create Advertising Construction';
$this->params['breadcrumbs'][] = ['label' => 'Advertising Constructions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
