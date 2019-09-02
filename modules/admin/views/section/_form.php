<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\entities\Section */
/* @var $types array app\models\entities\SectionTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_id')->dropDownList($types, ['prompt' => 'Выберите тип секции']) ?>

    <?= $form->field($model, 'title')->widget(CKEditor::className(), [
        'options' => ['rows' => 3],
        'preset' => 'basic',
    ])  ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'custom-btn blue']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
