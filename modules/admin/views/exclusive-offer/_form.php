<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\entities\ExclusiveOfferPage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exclusive-offer-page-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'formatted_text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
    ])  ?>

    
    <p>
        <img src="<?php echo $model->path; ?>" />
    </p>
    <p>Если Вы выберете новый файл, то старое изображение будет заменено.</p>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'facebook_title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить изменения', ['class' => 'custom-btn blue']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
