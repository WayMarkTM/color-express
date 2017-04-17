<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 6:48 PM
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $documentForm \app\models\AddDocumentForm */
/* @var $months array|mixed */
/* @var $years array|mixed */
?>

<div id="add-document" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center text-uppercase"><strong>Добавление документа</strong></h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'add-document-form',
                        'options' => ['class' => 'modal-form'],
                        'enableAjaxValidation' => true,
                        'validationUrl' => Url::toRoute('documents/upload-validation')
                    ])
                    ?>

                    <?= $form->field($documentForm, 'month')->dropDownList($months, ['prompt' => 'Месяц'])->label('Период') ?>

                    <?= $form->field($documentForm, 'year')->textInput(['placeholder' => 'Год'])->label(false) ?>

                    <?= $form->field($documentForm, 'documentFile')->fileInput([
                        'accept' => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ])?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <?= Html::submitButton('Добавить', ['class' => 'modal-btn form-control btn text-uppercase']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>