<div id="signup" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-uppercase"><strong>Регистрация</strong></h4>
            </div>
            <div class="modal-body">
                <?= $this->render('@app/views/layouts/_partial/_client_form', [
                    'model' => $model
                ]); ?>
            </div>
            <div class="modal-footer">
                <h5 class="pull-left">Все поля обязательны для заполнения</h5>
            </div>
        </div>

    </div>
</div>
<?php if (Yii::$app->session->hasFlash('signupSuccess')): ?>
<script>
    toastr.success('Благодарим за регистрацию. Ваша заявка принята на рассмотрение. Уведомление о завершении регистрации будет выслано Вам на электронную почту');
</script>
<?php endif;?>
