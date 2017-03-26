<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/13/2017
 * Time: 12:10 AM
 */

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

/**
 * takes an array of models and their attributes names and outputs them as json. works with relations unlike CJSON::encode()
 * @param $models array an array of models, consider using $dataProvider->getData() here
 * @param $attributeNames string a comma delimited list of attribute names to output, for relations use relationName.attributeName
 * @return string json object
 */

function database_model_to_array(array $models, $attributeNames) {
    $attributeNames = explode(',', $attributeNames);

    $rows = array(); //the rows to output
    foreach ($models as $model) {
        $row = array(); //you will be copying in model attribute values to this array
        foreach ($attributeNames as $name) {
            $name = trim($name); //in case of spaces around commas
            $row[$name] = $model[$name]; //this function walks the relations
        }
        $rows[] = $row;
    }

    return $rows;
}

function json_encode_database_models(array $models, $attributeNames) {
    return json_encode(database_model_to_array($models, $attributeNames));
}

$modelAttributeNames = 'id, name, latitude, longitude, advertisingConstructionImages';
$models =  database_model_to_array($dataProvider->getModels(), $modelAttributeNames);

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
                'content' => $model['name'].'<br/><img src="'.$model['advertisingConstructionImages'][0].'" />'
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
                            'layout'=>'{items}<div class="grid-footer-panel"><button class="custom-btn sm blue" type="button">Купить</button><button class="custom-btn sm blue" type="button">Отложить на 5 дней</button>{pager}</div>',
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
                                            return Html::a('Подробнее', 'advertising-construction/details?id='.$model->id, [
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