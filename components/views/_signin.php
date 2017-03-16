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
                        'options' => ['class' => 'modal-form'],
                    ])
                    ?>
                    <?= $form->field($auth_form, 'username')->textInput([
                        'placeholder' => 'Введите рабочий e-mail'
                        ])
                    ?>
                    <?= $form->field($auth_form, 'password')->passwordInput([
                        'placeholder' => 'Не менее 8 символов'
                        ])
                    ?>
                    <div class="form-group">
                        <?= Html::checkbox("LoginForm[rememberMe]", true,[
                            'id' => 'loginform-rememberme',
                            'class' => 'hide modal-checkbox',
                            'label' => '<label for="loginform-rememberme">Сохранить пароль</label>']
                        ); ?>

                                <span class="pull-right" style="text-align:right;"><u>Забыли логин или пароль?</u></span>
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