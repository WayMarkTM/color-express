<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/13/2017
 * Time: 12:10 AM
 */

use app\services\JsonService;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdvertisingConstructionSearch */
/* @var $constructions array|app\models\entities\AdvertisingConstruction */
/* @var $sizes array */
/* @var $types array */

$coord = new LatLng(['lat' => 53.8905047, 'lng' => 27.5292012]);

$map = new Map([
    'center' => $coord,
    'zoom' => 11,
    'width' => '100%',
    'height' => '450'
]);

foreach($constructions as $model) {
    if ($model['latitude'] && $model['longitude']) {
        $marker = new Marker([
            'position' => new LatLng([
                'lat' => $model->latitude,
                'lng' => $model->longitude
            ]),
            'title' => $model->name
        ]);

        $infoWindowContent = $model->name;
        if (count($model->advertisingConstructionImages) > 0) {
            $infoWindowContent .= '<br/><br/><img class="info-window-image-preview" src="/' . $model->advertisingConstructionImages[0]->path . '"/>';
        }

        $marker->attachInfoWindow(
            new InfoWindow([
                'content' => $infoWindowContent
            ])
        );

        $map->addOverlay($marker);
    }
}

$mappedConstructions = array();
foreach ($constructions as $construction) {
    array_push($mappedConstructions, [
        'id' => $construction->id,
        'address' => $construction->address,
        'price' => $construction->price,
        'size' => $construction->size->size,
        'name' => $construction->name,
        'previewImage' => count($model->advertisingConstructionImages) > 0 ?
            $model->advertisingConstructionImages[0]->path :
            '',
        'isSelected' => false
    ]);
}

$this->registerJs('var constructions = '.json_encode($mappedConstructions).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var constructionTypes = '.json_encode($types).';', \yii\web\View::POS_BEGIN);
$this->registerJs('var selectedConstructionType = '.json_encode($searchModel->type_id).';', \yii\web\View::POS_BEGIN);
$this->registerJsFile('@web/js/angular.min.js');
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
                <div class="map" id="mapCanvas"><?php echo $map->display(); ?></div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-4">
                    <?= $this->render('_search', [
                        'model' => $searchModel,
                        'sizes' => $sizes
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
                            <tr ng-repeat="construction in $ctrl.constructions" ng-if="$ctrl.constructions.length > 0">
                                <td class="text-center">
                                    <input type="checkbox" ng-model="construction.isSelected" name="selectedConstruction_{{$index}}" />
                                </td>
                                <td>{{ construction.name }}</td>
                                <td>{{ construction.address }}</td>
                                <td class="text-center">{{ construction.size }}</td>
                                <td class="text-center">{{ construction.price }}</td>
                                <td class="text-center">(не задано)</td>
                                <td class="text-center">
                                    <a href="/construction/details?id={{ construction.id}}">Подробнее</a>
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
                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.buyConstructions()">Купить</button>
                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.reservConstructions()">Отложить на 5 дней</button>
                        <button class="custom-btn sm blue" type="button" ng-click="$ctrl.showSummary()">Сводка</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>