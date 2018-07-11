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
/* @var $manageId */
/* @var $multiple boolean */

$isEmployee = false;
if (Yii::$app->user->can('employee')) {
    $isEmployee = true;
}

$attributes = 'id,company,name,surname,is_agency,manage_id';

$jsonReservations = JsonService::json_encode_database_models($clients, $attributes);

$position = View::POS_BEGIN;
$this->registerJs('var companies = '.$jsonReservations.';', $position);

if(!$manageId) {
    $manageId = 'undefined';
}
$this->registerJs('var manageId = '. $manageId .';', $position);
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
                    <?php if ($isEmployee): ?>
                        <div class="col-sm-7">
                            <ul class="nav nav-tabs modal-custom-tabs pull-right">
                                <li role="presentation" ng-click="$ctrl.setTab($ctrl.tabs[0])" ng-class="{'active': $ctrl.currentTab == $ctrl.tabs[0]}">
                                    <a href="#" class="text-uppercase">Список Ваших клиентов</a>
                                </li>
                                <li role="presentation" ng-click="$ctrl.setTab($ctrl.tabs[1])" ng-class="{'active': $ctrl.currentTab == $ctrl.tabs[1]}">
                                    <a href="#" class="text-uppercase">Список всех клиентов</a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
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
                                <tr ng-repeat="company in $ctrl.companies | filter:$ctrl.search | filter:$ctrl.tab | orderBy:$ctrl.propertyName:$ctrl.reverse"
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

