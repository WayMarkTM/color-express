<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 13.03.2017
 * Time: 15:09
 */

use app\components\CompanySelectionWidget;
use app\components\RequireAuthorizationWidget;
use app\models\entities\MarketingType;
use app\models\User;
use app\services\JsonService;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstruction */
/* @var $reservationModel app\models\AdvertisingConstructionFastReservationForm */
/* @var $marketing_types array app\models\entities\MarketingType */
/* @var $bookings array|app\models\entities\AdvertisingConstructionReservation */
/* @var $reservations array|app\models\entities\AdvertisingConstructionReservation */


$coord = new LatLng(['lat' => $model->latitude, 'lng' => $model->longitude]);

$map = new Map([
    'center' => $coord,
    'zoom' => 16,
    'width' => '100%',
    'height' => '450'
]);

if ($model->latitude && $model->longitude) {
    $marker = new Marker([
        'position' => new LatLng([
            'lat' => $model->latitude,
            'lng' => $model->longitude
        ]),
        'title' => $model->name
    ]);

    $marker->attachInfoWindow(
        new InfoWindow([
            'content' => $model->name
        ])
    );

    $map->addOverlay($marker);
}

$this->title = $model->name.' | Информация о рекламной конструкции';

if (Yii::$app->user->isGuest) {
    RequireAuthorizationWidget::begin();
    RequireAuthorizationWidget::end();
} else {
    CompanySelectionWidget::begin();
    CompanySelectionWidget::end();
}

$position = View::POS_BEGIN;
$this->registerJs('var isEmployee;', $position);
$this->registerJs('var isGuest = '.json_encode(Yii::$app->user->isGuest).';', $position);
?>

<link rel="stylesheet" href="/web/styles/vis.min.css" />
<script src="/web/js/jssor.slider.min.js" type="text/javascript"></script>
<script type="text/javascript">
    jssor_1_slider_init = function() {

        var jssor_1_SlideshowTransitions = [
            {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
            {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
        ];

        var jssor_1_options = {
            $AutoPlay: true,
            $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor_1_SlideshowTransitions,
                $TransitionsOrder: 1
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 10,
                $SpacingX: 8,
                $SpacingY: 8,
                $Align: 360
            }
        };

        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

        /*responsive code begin*/
        /*remove responsive code if you don't want the slider scales while window resizing*/
        function ScaleSlider() {
            var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
            if (refSize) {
                refSize = Math.min(refSize, 800);
                jssor_1_slider.$ScaleWidth(refSize);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }
        ScaleSlider();
        $Jssor$.$AddEvent(window, "load", ScaleSlider);
        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
        /*responsive code end*/
    };
</script>

<link rel="stylesheet" href="/web/styles/gallery.css"/>

<div class="advertising-construction-details">
    <div class="row">
        <div class="col-md-8">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:800px;height:556px;overflow:hidden;visibility:hidden;background-color:#24262e;">
                        <!-- Loading Screen -->
                        <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
                            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                            <div style="position:absolute;display:block;background:url('/web/images/gallery/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                        </div>
                        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:800px;height:556px;overflow:hidden;">
                            <?php
                                foreach ($model->advertisingConstructionImages as $image) {
                            ?>
                                <div>
                                    <img data-u="image" src="/<?php echo $image->path; ?>" />
                                    <img data-u="thumb" src="/<?php echo $image->path; ?>" />
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                        <!-- Thumbnail Navigator -->
                        <div data-u="thumbnavigator" class="jssort01" style="position:absolute;left:0px;bottom:0px;width:800px;height:100px;" data-autocenter="1">
                            <!-- Thumbnail Item Skin Begin -->
                            <div data-u="slides" style="cursor: default;">
                                <div data-u="prototype" class="p">
                                    <div class="w">
                                        <div data-u="thumbnailtemplate" class="t"></div>
                                    </div>
                                    <div class="c"></div>
                                </div>
                            </div>
                            <!-- Thumbnail Item Skin End -->
                        </div>
                        <!-- Arrow Navigator -->
                        <span data-u="arrowleft" class="jssora05l" style="top:248px;left:8px;width:40px;height:40px;"></span>
                        <span data-u="arrowright" class="jssora05r" style="top:248px;right:8px;width:40px;height:40px;"></span>
                    </div>
                    <script type="text/javascript">jssor_1_slider_init();</script>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <div class="status-panel">
                        <div class="item">
                            <span class="indicator booked"></span><span class="text"> - Забронировано</span>
                        </div>
                        <div class="item">
                            <span class="indicator reserved"></span><span class="text"> - Зарезервировано</span>
                        </div>
                        <div class="item">
                            <span class="indicator free"></span><span class="text"> - Свободно</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <div id="timeline"></div>

                    <?php
                        $position = View::POS_BEGIN;
                        $jsonReservations = array();
                        foreach ($bookings as $booking) {
                            array_push($jsonReservations, [
                                'id' => $booking->id,
                                'from' => $booking->from,
                                'to' => $booking->to,
                                'type' => 'booking'
                            ]);
                        }

                        foreach($reservations as $reservation) {
                            array_push($jsonReservations, [
                                'id' => $reservation->id,
                                'from' => $reservation->from,
                                'to' => $reservation->to,
                                'type' => 'reservation'
                            ]);
                        }

                        $this->registerJs('var reservations = '.json_encode($jsonReservations).';', $position);
                        $this->registerJsFile('@web/js/vis.min.js');
                        $this->registerJsFile('@web/js/app/construction-timeline.js');
                    ?>
                </div>
            </div>
            <?php echo $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); ?>
            <div class="row block-row datepicker-row">
                <div class="col-md-6 input-value">
                    Вы можете изменить период для бронирования рекламной конструкции:
                </div>
                <div class="col-md-6">
                    <?php
                    $rangeLayout = '<div class="row"><div class="col-md-6">'.
                        '<span class="range-prefix">с </span>{input1}'.
                        '</div><div class="col-md-6">'.
                        '<span class="range-prefix">по </span>{input2}'.
                        '</div></div>';

                    echo DatePicker::widget([
                        'type' => DatePicker::TYPE_RANGE,
                        'name' => 'from',
                        'attribute' => 'fromDate',
                        'name2' => 'to',
                        'attribute2' => 'toDate',
                        'layout' => $rangeLayout,
                        'form' => $form,
                        'model' => $reservationModel,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'format' => 'dd.mm.yyyy'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="row block-row">
                <div class="col-md-6 input-value">
                    Тип рекламы
                </div>
                <div class="col-md-6">
                    <?= Html::dropDownList('marketing-type', null, ArrayHelper::map(MarketingType::find()->all(), 'id', 'name'), [
                        'class' => 'form-control',
                        'id' => 'marketing-type'
                    ]) ?>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <a href="#" class="reminder-link pull-right">Уведомить, когда освободится</a>
                </div>
            </div>
            <div class="row buttons-row block-row">
                <div class="col-md-12">
                    <button type="button" id="buy-btn" class="custom-btn sm blue" data-action-type="buyConstruction">Купить</button>
                    <button type="button" id="reserv-btn" class="custom-btn sm blue" data-action-type="reservConstruction">Отложить на 5 дней</button>
                    <?= Html::a('Вернуться назад', ['/construction/index'], ['class'=>'custom-btn sm white']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $map->display(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="details-row">
                        <p><span class="bold">Название:</span> <?php echo $model->name; ?></p>
                        <p><span class="bold">Адрес:</span> <?php echo $model->address; ?></p>
                    </div>
                    <div class="details-row">
                        <p><span class="bold">Формат:</span> <?php echo $model->size->size; ?> м.</p>
                        <p><span class="bold">Тип:</span> <?php echo $model->type->name; ?></p>
                    </div>
                    <?php if ($model->nearest_locations) { ?>
                    <div class="details-row">
                        <p><span class="bold">Рядом расположены:</span> <?php echo $model->nearest_locations; ?></p>
                    </div>
                    <?php }
                        if ($model->traffic_info) {
                    ?>
                    <div class="details-row">
                        <p><span class="bold">Трафик:</span> <?php echo $model->traffic_info; ?></p>
                    </div>
                    <?php } ?>
                    <div class="details-row">
                        <p><span class="bold">Светофоры:</span> <?php echo $model->has_traffic_lights ? 'есть' : 'нет'; ?></p>
                    </div>
                    <div class="details-row">
                        <a href="/<?php echo $model->requirements_document_path; ?>">Скачать технические требования для печати плаката.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$(document).ready(function () {
    var buyBtn = $('#buy-btn'),
        reservBtn = $('#reserv-btn'),
        model = {
            id: function () {
                return $('#advertisingconstruction-id').val();
            },
            marketingType: function () {
                return $('#marketing-type').val();
            },
            dateFrom: function () {
                return $('#advertisingconstructionfastreservationform-fromdate').val();
            },
            dateTo: function () {
                return $('#advertisingconstructionfastreservationform-todate').val();
            }
        };

    buyBtn.on('click', buyConstruction);
    reservBtn.on('click', reservConstruction);

    function showRequireAuthorizationModal() {
        $('#requireAuthorization').modal('show');
    }
    
    function buyConstruction() {
        if (!!isGuest) {
            showRequireAuthorizationModal();
            return;
        }
        
        $('#company-selection').modal('show');
        return;
        
        var submitModel = {
            advertising_construction_id: model.id(),
            marketing_type: model.marketingType(),
            from: model.dateFrom(),
            to: model.dateTo()
        };

        colorApp.utilities.ajaxHelper.post({
            url: GATEWAY_URLS.BUY_CONSTRUCTION,
            data: submitModel
        }).done(function (result) {
            if (result.isValid) {
                window.location.href = BASE_URL + 'shopping-cart';
            } else {
                toastr.error(result.message);
            }
        });
    }

    function reservConstruction() {
        if (!!isGuest) {
            showRequireAuthorizationModal();
            return;
        }
        
        var submitModel = {
            advertising_construction_id: model.id(),
            marketing_type: model.marketingType(),
            from: model.dateFrom(),
            to: model.dateTo()
        };

        colorApp.utilities.ajaxHelper.post({
            url: GATEWAY_URLS.RESERV_CONSTRUCTION,
            data: submitModel
        }).done(function (result) {
            if (result.isValid) {
                window.location.href = BASE_URL + 'shopping-cart';
            } else {
                toastr.error(result.message);
            }
        });
    }
});
JS;

    $position = \yii\web\View::POS_READY;
    $this->registerJs($script, $position);
?>

