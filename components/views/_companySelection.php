<?php
use app\models\User;
use app\services\JsonService;
use yii\web\View;

/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 01.05.2017
 * Time: 15:07
 */

/* @var $clients array|User[] */
/* @var $multiple boolean */

$attributes = 'id,company,name,surname,is_agency';

$jsonReservations = JsonService::json_encode_database_models($clients, $attributes);

$position = View::POS_BEGIN;
$this->registerJs('var companies = '.$jsonReservations.';', $position);
if (!$multiple) {
    $this->registerJsFile('@web/js/app/company-selection.js');
}
?>

<div id="company-selection" class="modal fade" role="dialog" <?php echo $multiple ? '' : 'ng-app="company"' ?> ng-controller="companyListCtrl as $ctrl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4>Список компаний</h4>
                    </div>
                    <div class="col-sm-7">
                        <a data-toggle="modal" data-target="#signup" class="custom-btn blue">Добавить клиента</a>
                    </div>
                </div>
                <div class="row block-row">
                    <div class="col-sm-12">
                        <input type="text"
                               placeholder="Введите данные для поиска"
                               class="full-width form-control"
                               ng-model="$ctrl.search.company" />
                    </div>
                </div>
                <div class="row block-row">
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">№</th>
                                    <th class="text-center"><a href="" ng-click="$ctrl.sortBy('name')">Название</a></th>
                                    <th class="text-center">Контактное лицо</th>
                                    <th class="text-center"><a href="" ng-click="$ctrl.sortBy('is_agency')">Тип</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="company in $ctrl.companies | filter:$ctrl.search | orderBy:$ctrl.propertyName:$ctrl.reverse"
                                    class="selectable"
                                    ng-click="$ctrl.selectCompany(company)"
                                    ng-class="{'selected': $ctrl.selectedCompany.id == company.id }">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ company.company }}</td>
                                    <td>{{ company.name }} {{ company.surname }}</td>
                                    <td>{{ company.is_agency ? 'Агентство' : 'Заказчик' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row block-row">
                    <div class="col-sm-9">
                        <button type="button"
                                ng-click="$ctrl.buy()"
                                class="custom-btn red sm full-width">Купить</button>
                    </div>
                    <div class="col-sm-3">
                        <button type="button"
                                ng-click="$ctrl.cancel()"
                                class="custom-btn white sm full-width">Отмена</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= \app\components\SignupWidget::widget(); ?>
<script>
    $(document).ready(function() {
        $("#signup-form").submit(function(event) {
            event.preventDefault();
            $.post(
                '',
               $(this).serialize(),
            ).done(function(data) {
                toastr.success('Ваша заявка на регистрацию клиента была принята на рассмотрение.');
                $('#signup').modal('hide');
                $.pjax.reload({container: '#client-list'});
            });

            return false;
        });
    });
</script>

