<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionSize */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertising-construction-size-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'custom-btn blue']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
