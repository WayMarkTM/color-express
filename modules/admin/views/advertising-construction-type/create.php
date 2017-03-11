<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionType */

$this->title = 'Create Advertising Construction Type';
$this->params['breadcrumbs'][] = ['label' => 'Advertising Construction Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
