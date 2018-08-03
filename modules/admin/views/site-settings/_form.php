<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\entities\SiteSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->isImage()) {
        echo $form->field($model, 'value')->fileInput([
            'accept' => 'image/*'
        ]);
    } else if ($model->isCheckbox()) {
        echo $form->field($model, 'value')->checkbox(['label' => $model->name]);
    }else {
        echo $form->field($model, 'value')->textInput(['maxlength' => true]);
    } ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
