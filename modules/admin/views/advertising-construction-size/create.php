<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionSize */

$this->title = 'Создание размера рекламной конструкции';
$this->params['breadcrumbs'][] = ['label' => 'Управление размерами рекламных конструкций', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-construction-size-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
