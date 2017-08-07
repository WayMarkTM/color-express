<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\AdvertisingConstructionForm */
/* @var $sizes array app\models\entities\AdvertisingConstructionSize */
/* @var $types array app\models\entities\AdvertisingConstructionType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertising-construction-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'use_manual_coordinates')->checkBox(['selected' => $model->use_manual_coordinates]) ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'size_id')->dropDownList($sizes, ['prompt' => 'Выберите размер конструкции']) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_id')->dropDownList($types, ['prompt' => 'Выберите тип конструкции']) ?>

    <?= $form->field($model, 'nearest_locations')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'has_traffic_lights')->checkBox(['selected' => $model->has_traffic_lights]) ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?php if ($model->id > 0) {
        if (count($model->uploaded_images) > 0) {
            echo '<div class="form-group">';
                foreach ($model->uploaded_images as $image) { ?>
                    <div class="advertising-construction-image-preview">
                        <div class="image">
                            <img src="/<?php echo $image->path; ?>"/>
                        </div>
                        <div class="controls">
                            <button class="custom-btn red sm delete-image"
                                    data-id="<?php echo $image->id; ?>"
                                    type="button">Удалить</button>
                        </div>
                    </div>
                <?php }
            echo '</div>';
        }
    } ?>

    <?= $form->field($model, 'documentFile')->fileInput(['accept' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document']) ?>

    <?php if ($model->id > 0) {
        if ($model->document_path) { ?>
            <div class="form-group">
                <p>Внимание! При загрузке нового документа, старый будет удален.</p>
                <a href="/<?php echo $model->document_path; ?>">Текущий документ с техническими требованиями</a>
            </div>
        <?php }
    } ?>

    <?= $form->field($model, 'has_stock')->checkBox(['selected' => $model->has_stock]) ?>

    <?= $form->field($model, 'is_published')->checkBox(['selected' => $model->is_published]) ?>

    <?= $form->field($model, 'youtube_ids')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->id == null ? 'Создать' : 'Сохранить', ['class' => 'custom-btn blue']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(document).ready(function () {
    $('.delete-image').on('click', function () {
        var imageId = $(this).data('id'),
            that = this;
        
        colorApp.utilities.ajaxHelper.post({
            url: GATEWAY_URLS.DELETE_CONSTRUCTION_IMAGE,
            data: {
                imageId: imageId
            }
        }).done(function (result) {
            if (result.isValid) {
                $(that).parent().parent().remove();
                toastr.success('Изображение успешно удалено');
            } else {
                alert(result.message);
            }
        });    
    });  
})
JS;

$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
?>