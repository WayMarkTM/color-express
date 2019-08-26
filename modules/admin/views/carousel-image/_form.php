<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\entities\CarouselImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carousel-image-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false) ?>

    <?= $form->field($model, 'order')->textInput() ?>
    
    <?php if (!$model->isNewRecord) { ?>
        <p>
            <img src="<?php echo $model->path; ?>" />
        </p>
        <p>Если Вы выберете новый файл, то старое изображение будет заменено.</p>
    <?php } ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'custom-btn blue']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
