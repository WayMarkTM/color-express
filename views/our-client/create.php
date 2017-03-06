<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\OurClient */

$this->title = 'Create Our Client';
$this->params['breadcrumbs'][] = ['label' => 'Our Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="our-client-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
