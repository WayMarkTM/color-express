<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/13/2017
 * Time: 12:10 AM
 */

use app\components\CompanySelectionWidget;
use app\components\RequireAuthorizationWidget;
use app\models\constants\SystemConstants;
use app\models\entities\AdvertisingConstructionType;
use app\models\User;
use app\services\JsonService;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdvertisingConstructionSearch */
/* @var $constructions array|app\models\entities\AdvertisingConstruction */
/* @var $sizes array */
/* @var $types array */
/* @var $constructionTypes array */
/* @var $constructionType AdvertisingConstructionType */

$mappedConstructions = array();
foreach ($constructions as $construction) {
    $arr = [
        'id' => $construction->id,
        'address' => $construction->address,
        'size' => $construction->size->size,
        'name' => $construction->name,
        'long' => $construction->longitude,
        'lat' => $construction->latitude,
        'isBusy' => $construction->isBusy,
        'hasStock' => $construction->has_stock,
        'stock_text' => $construction->stock_text,
        'previewImage' => count($construction->advertisingConstructionImages) > 0 ?
            $construction->advertisingConstructionImages[0]->path :
            '',
        'isSelected' => false
    ];

    if (!Yii::$app->user->isGuest) {
        $arr['price'] = $construction->price;
    }

    array_push($mappedConstructions, $arr);
}

$mappedConstructionTypes = array();
foreach ($constructionTypes as $constrType) {
    $arr = [
        'id' => $constrType->id,
        'name' => $constrType->name,
        'additionalText' => $constrType->additional_text,
        'sortOrder' => $constrType->sort_order
    ];

    array_push($mappedConstructionTypes, $arr);
}

$isDatesSet = $searchModel->fromDate != null && $searchModel->toDate != null;
$isAgency = false;
if (!Yii::$app->user->isGuest) {
    $user = User::findOne(Yii::$app->user->getId());
    $isAgency = $user->is_agency;
}

$this->registerJs('var constructions = '.json_encode($mappedConstructions).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var constructionTypes = '.json_encode($mappedConstructionTypes).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var selectedConstructionType = '.json_encode($searchModel->type_id).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var isGuest = '.json_encode(Yii::$app->user->isGuest).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var isAgency = '.json_encode($isAgency).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var agencyCharge = '.json_encode(SystemConstants::AGENCY_PERCENT).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var isDatesSet = '.json_encode($isDatesSet).';', \yii\web\View::POS_BEGIN);

if (Yii::$app->user->isGuest) {
    RequireAuthorizationWidget::begin();
    RequireAuthorizationWidget::end();
    $isEmployee = false;
} else {
    $role = User::findIdentity(Yii::$app->user->getId())->getRole();
    $isEmployee = $role == 'employee';
}

$this->registerJs('var isEmployee = '.json_encode($isEmployee).';', \yii\web\View::POS_BEGIN);
$this->registerJsFile('@web/js/ui-bootstrap-tpls-2.5.0.min.js');
$this->registerJsFile('@web/js/ya-map-2.1.min.js');
$this->registerJsFile('@web/js/app/constructions.js');

$this->title = "Каталог рекламных конструкций";

?>

<div class="advertising-construction-page-container" ng-app="constructions" ng-controller="constructionsCtrl as $ctrl">
    <?php if ($isEmployee) {
        CompanySelectionWidget::begin(['param' => 'multiple']);
        CompanySelectionWidget::end();
    } ?>
    <div class="advertising-construction-list-container">
        <div class="row">
            <div class="col-md-12">
                <div class="construction-type-navigation-container">
                    <div class="horizontal-menu">
                        <div class="menu">
                            <div class="menu-item"
                                 ng-class="{'active' : type.id == $ctrl.selectedConstructionType }"
                                 ng-repeat="type in $ctrl.constructionTypes"
                                 ng-click="$ctrl.selectConstructionType(type.id)">
                                <a href="" ng-bind="type.name"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ya-map ya-zoom="11" ya-center="[27.5292012,53.8905047]">
                    <ya-geo-object ng-repeat="construction in $ctrl.constructions"
                                   ya-source="construction.yaPoint"
                                   ya-controls="smallMapDefaultSet"
                                   ya-event-balloonopen="$ctrl.selectConstruction(construction)"
                                   ya-show-balloon="construction.id == $ctrl.selectedConstruction.id"
                                   ya-options="{preset:'islands#icon',iconColor: '#a5260a'}"></ya-geo-object>
                </ya-map>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-4">
                    <?= $this->render('_search', [
                        'model' => $searchModel,
                        'sizes' => $sizes,
                        'constructionType' => $constructionType
                    ]) ?>
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center">Название</th>
                                <th class="text-center">Адрес</th>
                                <th class="text-center">Размер</th>
                                <th class="text-center" style="width: 150px;">Цена в день, с НДС (BYN)</th>
                                <th class="text-center">Занятость</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="construction in $ctrl.constructions | startFrom: ($ctrl.currentPage-1)*$ctrl.ITEMS_PER_PAGE | limitTo: $ctrl.ITEMS_PER_PAGE"
                                ng-click="$ctrl.selectConstruction(construction)"
                                ng-class="{'selected-row': $ctrl.selectedConstruction.id == construction.id}"
                                ng-if="$ctrl.constructions.length > 0">
                                <td class="text-center">
                                    <input type="checkbox"
                                           id="construction_{{construction.id}}"
                                           class="modal-checkbox hide"
                                           ng-model="construction.isSelected"
                                           name="selectedConstruction_{{$index}}"
                                           ng-disabled="construction.isBusy"/>
                                    <label for="construction_{{construction.id}}"></label>
                                </td>
                                <td ng-bind="construction.name"></td>
                                <td ng-bind="construction.address"></td>
                                <td class="text-center" ng-bind="construction.size"></td>
                                <td class="text-center">
                                    <span ng-if="!$ctrl.isGuest" ng-class="{ 'price-with-badge' : construction.hasStock }">
                                        <span class="price" ng-bind="$ctrl.getPricePerDay(construction)"></span>
                                        <span ng-if="construction.hasStock" class="badge" title="{{construction.stock_text}}" ng-bind="construction.stock_text"></span>
                                    </span>
                                    <a ng-if="$ctrl.isGuest" href="#" ng-click="$ctrl.showRequireAuthorizationModal()">Зарегистрироваться</a>
                                </td>
                                <td class="text-center" ng-bind="$ctrl.getConstructionStatus(construction)"></td>
                                <td class="text-center">
                                    <a href="/construction/details?id={{ construction.id}}&q={{$ctrl.getQueryString()}}">Подробнее</a>
                                </td>
                            </tr>
                            <tr ng-if="$ctrl.constructions.length > 0 && $ctrl.isAgency">
                                <td class="invisible" colspan="4"></td>
                                <td class="text-left note-message" colspan="3">* Со скидкой для Рекламных Агентств</td>
                            </tr>
                            <tr ng-if="!$ctrl.constructions || $ctrl.constructions.length == 0">
                                <td colspan="7">
                                    Ничего не найдено.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="grid-footer-panel">
                        <ul uib-pagination
                            boundary-links="true"
                            direction-links="false"
                            total-items="$ctrl.constructions.length"
                            items-per-page="$ctrl.ITEMS_PER_PAGE"
                            ng-model="$ctrl.currentPage"
                            class="pagination-sm"
                            previous-text="&lsaquo;"
                            next-text="&rsaquo;"
                            first-text="&laquo;"
                            last-text="&raquo;"></ul>

                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.buyConstructions()">Купить</button>
                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.reservConstructions()">Отложить на 5 дней</button>
                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.showSummary()" ng-if="$ctrl.isEmployee">Сводка</button>
                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.getReport()" ng-if="$ctrl.isEmployee">Отчет</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12">
                {{ $ctrl.getSelectedConstructionAdditionalText() }}
                </div>
            </div>
        </div>
        <div class="watermark">
            Сайт носит рекламно-информационный характер и не используется в качестве интернет-магазина, в том числе для торговли по образцам и с помощью курьера.
        </div>
    </div>
</div>