<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 22.05.2017
 * Time: 22:13
 *
 * @var $forgotPassForm \app\models\ForgotPassForm
 *
 */
use \yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<div id="forgot_pass" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center text-uppercase"><strong>EMAIL</strong></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'forgot-pass-form',
                        'options' => ['class' => 'modal-form'],
                        'validationUrl' => Url::toRoute('admin/user/validate-forgot-pass')
                    ])
                    ?>
                    <?= $form->field($forgotPassForm, 'username', ['enableAjaxValidation' => true])->textInput([
                        'placeholder' => 'Введите рабочий e-mail'
                    ])
                    ?>
                    <div class="form-group">
                        <?= Html::submitButton('Сбросить пароль', ['class' => 'modal-btn form-control btn text-uppercase']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
            <div class="modal-footer">
                <h5 class="pull-left">*Данно действие нельзя будет отменить</h5>
            </div>
        </div>

    </div>
</div>
<?php if (Yii::$app->session->hasFlash('resetSuccess')): ?>
    <script>
        toastr.success('Вам выслан ваш новый пароль на почту.');
    </script>
<?php endif;?>
