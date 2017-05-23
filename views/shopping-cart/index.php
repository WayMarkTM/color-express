<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 7:37PM
 */

use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $cartItems array|app\models\entities\AdvertisingConstructionReservation */
/* @var $marketingTypes array|app\models\entities\MarketingType*/

$this->title = 'Корзина';

$jsonCartItems = array();
foreach ($cartItems as $item) {
    array_push($jsonCartItems, [
        'id' => $item->id,
        'advertising_construction_id' => $item->advertisingConstruction->id,
        'name' => $item->advertisingConstruction->name,
        'address' => $item->advertisingConstruction->address,
        'from' => $item->from,
        'to' => $item->to,
        'created_at' => $item->created_at,
        'status_id' => $item->status_id,
        'price' => $item->advertisingConstruction->price,
        'cost' => $item->cost,
        'company' => $item->user->company
    ]);
}

$isEmployee = false;
if (User::findIdentity(Yii::$app->user->getId())->getRole() == 'employee') {
    $isEmployee = true;
}

$mtAttributes = 'id,name,charge';
$jsonMarketingTypes = \app\services\JsonService::json_encode_database_models($marketingTypes, $mtAttributes);

$position = View::POS_BEGIN;
$this->registerJs('var cartItems = '.json_encode($jsonCartItems).';', $position);
$this->registerJs('var isEmployee = '.json_encode($isEmployee).';', $position);
$this->registerJs('var marketingTypes = '.$jsonMarketingTypes.';', $position);
$this->registerJsFile('@web/js/angular-locale_ru-ru.js');
$this->registerJsFile('@web/js/ui-bootstrap-tpls-2.5.0.min.js');
$this->registerJsFile('@web/js/vis.min.js');
$this->registerJsFile('@web/js/app/construction-timeline.js');
$this->registerJsFile('@web/js/app/shopping-cart.js');
?>

<link rel="stylesheet" href="/web/styles/vis.min.css" />
<div class="shopping-cart-container" ng-app="shoppingCart" ng-controller="shoppingCartCtrl as $ctrl">
    <form name="$ctrl.form" class="form-inline" ng-submit="$ctrl.submit()" novalidate>
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-uppercase">Корзина</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" width="30">#</th>
                        <th class="text-center">Название</th>
                        <th class="text-center">Адрес</th>
                        <th class="text-center" width="250">Даты использования</th>
                        <th class="text-center" width="220">Стоимость за период, BYN (стоимость в месяц, BYN)</th>
                        <th class="text-center" width="180">Тип рекламы</th>
                        <th class="text-center" ng-if="$ctrl.isEmployee">Компания</th>
                        <th width="180">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in $ctrl.cartItems">
                            <td class="text-center" ng-bind="$index + 1"></td>
                            <td><a href="/construction/details?id={{item.advertising_construction_id}}" ng-bind="item.name"></a> <span ng-if="item.status_id == 11">(резерв до <span ng-bind="$ctrl.getReservationTillDate(item.created_at)"></span>)</span></td>
                            <td ng-bind="item.address"></td>
                            <td class="text-center"><span ng-bind="item.from + ' - ' + item.to"></span> <a href="" ng-click="$ctrl.editPeriod(item)" class="additional-link"><i class="icon edit-icon"></i></a></td>
                            <td class="text-center" ng-bind="item.cost + ' (' + (item.price * 30).toFixed(2) + ')'"></td>
                            <td class="text-center">
                                <select class="form-control" ng-model="item.marketing_type_id" ng-change="$ctrl.onItemMarketingTypeChanged(item)">
                                    <option ng-repeat="mt in $ctrl.marketingTypes" value="{{ mt.id }}" ng-bind="mt.name"></option>
                                </select>
                            </td>
                            <td ng-if="$ctrl.isEmployee" ng-bind="item.company"></td>
                            <td class="text-center">
                                <a href="" class="custom-btn sm white" ng-click="$ctrl.removeItem(item)">
                                    Удалить из корзины
                                </a>
                            </td>
                        </tr>
                        <tr ng-if="!$ctrl.cartItems || $ctrl.cartItems.length == 0">
                            <td colspan="7">
                                Отсутствуют элементы в корзине.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div ng-if="$ctrl.cartItems.length > 0">
            <div class="row block-row">
                <div class="col-md-4">
                    <span class="shopping-cart-total">Итого: <span class="total-cost" ng-bind="$ctrl.getTotalCost()"></span> бел. руб. с НДС</span>
                </div>
                <div class="col-md-8">
                    <div class="pull-right">
                        <label class="control-label">Укажите, пожалуйста, тематику сюжета:</label>
                        <input type="text"
                               class="form-control"
                               placeholder="Например: телефоны"
                               style="width: 300px; margin-left: 15px;"
                               required
                               name="thematic"
                               ng-class="{ 'has-error' : $ctrl.form.$submitted && $ctrl.form.thematic.$error.required }"
                               ng-model="$ctrl.thematic"/>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row block-row">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="custom-btn blue full-width">Подтвердить</button>
                </div>
            </div>
        </div>
    </form>
</div>