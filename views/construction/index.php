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
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $sizes array yii\data\AdvertisingConstructionSize*/

$modelAttributeNames = 'id, name, latitude, longitude, advertisingConstructionImages';
$models =  JsonService::database_model_to_array($dataProvider->getModels(), $modelAttributeNames);

$coord = new LatLng(['lat' => 53.8905047, 'lng' => 27.5292012]);

$map = new Map([
    'center' => $coord,
    'zoom' => 11,
    'width' => '100%',
    'height' => '450'
]);

foreach($models as $model) {
    if ($model['latitude'] && $model['longitude']) {
        $marker = new Marker([
            'position' => new LatLng([
                'lat' => $model['latitude'],
                'lng' => $model['longitude']
            ]),
            'title' => $model['name']
        ]);

        $marker->attachInfoWindow(
            new InfoWindow([
                'content' => $model['name']
            ])
        );

        $map->addOverlay($marker);
    }
}


$this->title = "Каталог рекламных конструкций";
?>

<div class="advertising-construction-page-container">
    <div class="advertising-construction-list-container">
        <div class="row">
            <div class="col-md-12">
                <div class="construction-type-navigation-container">
                    <div class="horizontal-menu">
                        <div class="menu">
                            <div class="menu-item"><a href="#">Щитовые рекламные конструкции</a></div>
                            <div class="menu-item"><a href="#">Брандмауэры</a></div>
                            <div class="menu-item"><a href="#">Настенные световые короба</a></div>
                            <div class="menu-item active"><a href="#">Рекламные конструкции на путепроводах</a></div>
                            <div class="menu-item"><a href="#">Надкрышные световые короба</a></div>
                            <div class="menu-item"><a href="#">Лайтбоксы в метро и переходах</a></div>
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
                    <?php Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'layout'=>'{items}<div class="grid-footer-panel"><button class="custom-btn sm blue" type="button">Купить</button><button class="custom-btn sm blue" type="button">Отложить на 5 дней</button><button id="summary" class="custom-btn sm blue" type="button">Сводка</button>{pager}</div>',
                            'columns' => [
                                [
                                    'class' => 'yii\grid\CheckboxColumn',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' =>['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'name',
                                    'headerOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'address',
                                    'headerOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'size.size',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' =>['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'Занятость',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' =>['class' => 'text-center'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{details}',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' =>['class' => 'text-center'],
                                    'buttons' => [
                                        'details' => function ($url ,$model) {
                                            return Html::a('Подробнее', 'construction/details?id='.$model->id, [
                                                'title' => 'Подробнее'
                                            ]);
                                        }
                                    ]
                                ],
                            ],
                        ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#summary').on('click', function () {
        var queryString = window.location.href.slice(window.location.href.indexOf('?') + 1)
        window.location.href = '/construction/summary?' + queryString;
    });
</script>