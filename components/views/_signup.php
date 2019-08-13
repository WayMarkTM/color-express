<?php
/* @var $reloadWidget string */
?>
<div id="signup" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase"><strong>Регистрация</strong></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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

<script>
    $(document).ready(function () {
        <?php if (Yii::$app->session->hasFlash('signupSuccess')): ?>
            <?php if (Yii::$app->user->isGuest): ?>
                toastr.success('Заявка на регистрацию принята. Подтверждение регистрации Вы получите на указанный е-мейл.');
            <?php else: ?>
                toastr.success('Ваша заявка на регистрацию клиента была принята на рассмотрение.');
            <?php endif; ?>
            <?php if (!empty($reloadWidget)): ?>
                $.pjax.reload({container: '<?= $reloadWidget ?>'});
            <?php endif; ?>
        <?php endif; ?>
    });
</script>
