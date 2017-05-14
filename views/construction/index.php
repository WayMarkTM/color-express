<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/13/2017
 * Time: 12:10 AM
 */

use app\components\CompanySelectionWidget;
use app\components\RequireAuthorizationWidget;
use app\models\User;
use app\services\JsonService;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdvertisingConstructionSearch */
/* @var $constructions array|app\models\entities\AdvertisingConstruction */
/* @var $sizes array */
/* @var $addresses array */
/* @var $types array */

$mappedConstructions = array();
foreach ($constructions as $construction) {
    array_push($mappedConstructions, [
        'id' => $construction->id,
        'address' => $construction->address,
        'price' => $construction->price,
        'size' => $construction->size->size,
        'name' => $construction->name,
        'long' => $construction->longitude,
        'lat' => $construction->latitude,
        'previewImage' => count($construction->advertisingConstructionImages) > 0 ?
            $construction->advertisingConstructionImages[0]->path :
            '',
        'isSelected' => false
    ]);
}

$this->registerJs('var constructions = '.json_encode($mappedConstructions).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var constructionTypes = '.json_encode($types).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var selectedConstructionType = '.json_encode($searchModel->type_id).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var isGuest = '.json_encode(Yii::$app->user->isGuest).';', \yii\web\View::POS_BEGIN);

if (Yii::$app->user->isGuest) {
    RequireAuthorizationWidget::begin();
    RequireAuthorizationWidget::end();
    $isEmployee = false;
} else {
    $role = User::findIdentity(Yii::$app->user->getId())->getRole();
    $isEmployee = $role == 'employee';
//    CompanySelectionWidget::begin();
//    CompanySelectionWidget::end();
}

$this->registerJs('var isEmployee = '.json_encode($isEmployee).';', \yii\web\View::POS_BEGIN);
$this->registerJsFile('@web/js/ui-bootstrap-tpls-2.5.0.min.js');
$this->registerJsFile('@web/js/ya-map-2.1.min.js');
$this->registerJsFile('@web/js/app/constructions.js');

$this->title = "Каталог рекламных конструкций";

?>

<div class="advertising-construction-page-container" ng-app="constructions" ng-controller="constructionsCtrl as $ctrl">
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
                                <a href="">{{type.name}}</a>
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
                        'addresses' => $addresses
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
                                <th class="text-center" style="width: 120px;">Цена с НДС (бел.руб.)</th>
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
                                    <input type="checkbox" id="construction_{{construction.id}}" class="modal-checkbox hide" ng-model="construction.isSelected" name="selectedConstruction_{{$index}}" />
                                    <label for="construction_{{construction.id}}"></label>
                                </td>
                                <td>{{ construction.name }}</td>
                                <td>{{ construction.address }}</td>
                                <td class="text-center">{{ construction.size }}</td>
                                <td class="text-center">{{ construction.price }}</td>
                                <td class="text-center">(не задано)</td>
                                <td class="text-center">
                                    <a href="/construction/details?id={{ construction.id}}&q={{$ctrl.queryString}}">Подробнее</a>
                                </td>
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
                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.reservConstructions()" ng-if="!$ctrl.isEmployee">Отложить на 5 дней</button>
                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.showSummary()" ng-if="$ctrl.isEmployee">Сводка</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>