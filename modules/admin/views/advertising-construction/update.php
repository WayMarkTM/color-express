<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstruction */
/* @var $sizes array app\models\entities\AdvertisingConstructionSize */
/* @var $types array app\models\entities\AdvertisingConstructionType */

$this->title = 'Изменение рекламной конструкции: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рекламные конструкции', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="advertising-construction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-8">
            <?= $this->render('_form', [
                'model' => $model,
                'sizes' => $sizes,
                'types' => $types
            ]) ?>
        </div>
    </div>

</div>
