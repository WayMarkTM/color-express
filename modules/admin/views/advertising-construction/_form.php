<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstruction */
/* @var $sizes array app\models\entities\AdvertisingConstructionSize */
/* @var $types array app\models\entities\AdvertisingConstructionType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertising-construction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'size_id')->dropDownList($sizes, ['prompt' => 'Выберите размер конструкции']) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_id')->dropDownList($types, ['prompt' => 'Выберите тип конструкции']) ?>

    <?= $form->field($model, 'nearest_locations')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'traffic_info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'has_traffic_lights')->checkBox(['selected' => $model->has_traffic_lights]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
