<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 01.05.2017
 * Time: 14:19
 */

?>

<div id="requireAuthorization" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button"
                                class="custom-btn red sm full-width"
                                id="registrationButton">Регистрация</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button"
                                class="custom-btn blue sm full-width"
                                id="loginButton">Вход</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function () {
        $('#registrationButton').on('click', callRegistration);
        $('#loginButton').on('click', callLogin);

        function hideModal() {
            $('#requireAuthorization').modal('hide');
        }

        function callRegistration() {
            hideModal();
            $('#signup').modal('show')
        }

        function callLogin() {
            hideModal();
            $('#signin').modal('show')
        }
    })();
</script>