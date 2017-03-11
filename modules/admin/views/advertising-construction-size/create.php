<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionSize */

$this->title = 'Create Advertising Construction Size';
$this->params['breadcrumbs'][] = ['label' => 'Advertising Construction Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-size-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
