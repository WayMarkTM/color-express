<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div id="signup" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center text-uppercase"><strong>Вход</strong></h4>
      </div>
      <div class="modal-body">


          <div class="form-group">
              <div class="col-lg-offset-1 col-lg-11">
                  <?= Html::submitButton('Вход', ['class' => 'btn btn-primary']) ?>
              </div>
          </div>
          <?php // ActiveForm::end() ?>
      </div>
    </div>

  </div>
</div>