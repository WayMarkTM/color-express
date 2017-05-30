<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/31/2017
 * Time: 1:52 AM
 */
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $interruptionForm \app\models\InterruptionForm */

?>

<div id="interrupt-reservation-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center text-uppercase"><strong>Прерывание бронирования</strong></h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'interrupt-reservation-form',
                        'options' => ['class' => 'modal-form'],
                        'validationUrl' => Url::toRoute('construction/interrupt-validation')
                    ])
                    ?>

                    <?= $form->field($interruptionForm, 'id')->hiddenInput()->label(false) ?>

                    <?php echo DatePicker::widget([
                        'model' => $interruptionForm,
                        'attribute' => 'toDate',
                        'form' => $form,
                        'type' => DatePicker::TYPE_INPUT,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]); ?>

                    <?= $form->field($interruptionForm, 'cost')->textInput(['placeholder' => 'Стоимость за период (BYN)']) ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <?= Html::submitButton('Прервать', ['class' => 'modal-btn form-control btn text-uppercase']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

