<?php

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/app/jquery.uploadPreview.min.js');

$id = Yii::$app->user->can('employee') && $scenario == \app\models\SignupForm::SCENARIO_EDIT_EMPLOYEE ? 'employee_edit' : 'editable_client';

if (!isset($class)) {
    $class = 'client-editable';
}
?>
<div id="<?= $id ?>" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-uppercase"><strong><?= $title?></strong></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("$(function() {
    $('.".$class."').click(function(e) {
        e.preventDefault();
        var client_id = $(this).data('user-id');
        $.get( '/clients/get-client-info', 
            {
                'id': client_id,
                'scenario': '".$scenario."'
            },
            function(userData) {
                $('#".$id." .modal-body').html(userData);
                $('#".$id."').modal('show');    
        });
    });
});");