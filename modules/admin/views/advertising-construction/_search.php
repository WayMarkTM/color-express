<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdvertisingConstructionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertising-construction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'nearest_locations') ?>

    <?= $form->field($model, 'traffic_info') ?>

    <?= $form->field($model, 'has_traffic_lights') ?>

    <?php echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'size_id') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
