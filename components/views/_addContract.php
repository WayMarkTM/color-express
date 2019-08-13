<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 7/11/2017
 * Time: 12:05 AM
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $contractForm \app\models\AddContractForm */

?>

<div id="add-contract" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center text-uppercase"><strong>Добавление договора</strong></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'add-contract-form',
                        'options' => ['class' => 'modal-form'],
                        'validationUrl' => Url::toRoute('documents/upload-contract-validation')
                    ])
                    ?>

                    <?= $form->field($contractForm, 'subclientId')->hiddenInput()->label(false) ?>
                    <?= $form->field($contractForm, 'userId')->hiddenInput()->label(false) ?>
                    <?= $form->field($contractForm, 'year')->textInput(['placeholder' => 'Год'])->label(false) ?>
                    <?= $form->field($contractForm, 'documentFile')->fileInput([
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
