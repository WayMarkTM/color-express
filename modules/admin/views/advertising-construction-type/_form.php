<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstructionType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertising-construction-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'presentation_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput(['type' => 'number', 'max' => '255', 'min' => '0', 'step' => '1']) ?>

    <?= $form->field($model, 'additional_text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
    ])  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'custom-btn blue']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
