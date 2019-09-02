<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\Section */

$this->title = 'Создать секцию';
$this->params['breadcrumbs'][] = ['label' => 'Секции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'types' => $types
    ]) ?>

</div>
