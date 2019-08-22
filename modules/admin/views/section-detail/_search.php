<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\SectionDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="section-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'section_id') ?>

    <?= $form->field($model, 'formatted_text') ?>

    <?= $form->field($model, 'order') ?>

    <?= $form->field($model, 'image_path') ?>

    <?php // echo $form->field($model, 'link_to') ?>

    <?php // echo $form->field($model, 'link_text') ?>

    <?php // echo $form->field($model, 'link_icon') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
