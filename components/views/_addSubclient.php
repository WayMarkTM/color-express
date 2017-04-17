<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 8:24 PM
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $subclientForm \app\models\AddSubclientForm */
?>

<div id="add-subclient" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center text-uppercase"><strong>Добавление субклиента</strong></h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'add-subclient-form',
                        'options' => ['class' => 'modal-form'],
                        'validationUrl' => Url::toRoute('subclient/create-validation')
                    ])
                    ?>

                    <?= $form->field($subclientForm, 'name')->textInput() ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <?= Html::submitButton('Добавить', ['class' => 'modal-btn form-control btn text-uppercase']) ?>
                            <button type="button" class="modal-btn form-control btn text-uppercase" data-dismiss="modal">Отмена</button>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>