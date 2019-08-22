<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\entities\SectionDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'section_id')->textInput() ?>

    <?= $form->field($model, 'formatted_text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        ])  ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'image_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link_icon')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'custom-btn blue']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
