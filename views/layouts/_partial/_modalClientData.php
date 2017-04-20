<div id="editable_client" class="modal fade" role="dialog">
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
    $('.client-editable').click(function(e) {
        e.preventDefault();
        var client_id = $(this).data('user-id');
        $.get( '/clients/get-client-info', 
            {
                'id': client_id,
                'scenario': '".$scenario."'
            },
            function(userData) {
                $('#editable_client .modal-body').html(userData);
                $('#editable_client').modal('show');    
        });
    });
});");