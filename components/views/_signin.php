<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $auth_form \app\models\LoginForm */
?>

<div id="signin" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center text-uppercase"><strong>Вход</strong></h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'modal-form form-horizontal'],
                    ])
                    ?>
                    <?= $form->field($auth_form, 'username') ?>
                    <?= $form->field($auth_form, 'password')->passwordInput() ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <?= $form->field($auth_form, 'rememberMe')->checkbox() ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'modal-btn form-control btn text-uppercase']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>

    </div>
</div>