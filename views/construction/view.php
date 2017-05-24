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
use app\modules\admin\models\AdvertisingConstructionForm;
use app\services\JsonService;
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

$this->title = $model->name.' | Информация о рекламной конструкции';

if (Yii::$app->user->isGuest) {
    RequireAuthorizationWidget::begin();
    RequireAuthorizationWidget::end();
    $isEmployee = false;
} else {
    $role = User::findIdentity(Yii::$app->user->getId())->getRole();
    $isEmployee = $role == 'employee';
    CompanySelectionWidget::begin();
    CompanySelectionWidget::end();
}

$position = View::POS_BEGIN;
$this->registerJs('var isEmployee ='.json_encode($isEmployee), $position);
$this->registerJs('var isGuest = '.json_encode(Yii::$app->user->isGuest).';', $position);
?>

<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);

    function init () {
        var map = new ymaps.Map('map', {
                center: [<?php echo $model->latitude; ?>, <?php echo $model->longitude; ?>],
                zoom: 16
            }, {
                searchControlProvider: 'yandex#search'
            }),
            myGeoObject = new ymaps.GeoObject({
                geometry: {
                    type: "Point",
                    coordinates: [<?php echo $model->latitude; ?>, <?php echo $model->longitude; ?>]
                },
                properties: {
                    balloonContent: '<?php echo $model->name; ?>'
                }
            }, {
                preset:'islands#icon',
                iconColor: '#a5260a'
            });

        map.geoObjects.add(myGeoObject);
    }
</script>

<link rel="stylesheet" href="/web/styles/vis.min.css" />

<div class="advertising-construction-details">
    <div class="row">
        <div class="col-md-8">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-12">
                    <script type="text/javascript" src="/web/html5gallery/jquery.js"></script>
                    <script type="text/javascript" src="/web/html5gallery/html5gallery.js"></script>
                    <div style="display:none;"
                         class="html5gallery"
                         data-lightbox="true"
                         data-onchange="onSlideChange"
                         data-skin="gallery"
                         data-responsive="true"
                         data-width="756"
                         data-height="338"
                         data-showplaybutton="false"
                         data-titleoverlay="false"
                         data-showtitle="false"
                         data-thumbshowtitle="false"
                         data-thumbwidth="255"
                         data-thumbheight="120">
                        <!-- Add images to Gallery -->
                        <?php
                        foreach ($model->advertisingConstructionImages as $image) {
                            ?>

                            <a href="/<?php echo $image->path; ?>"><img src="/<?php echo $image->path; ?>"></a>
                            <?php
                            }
                        ?>
                    </div>
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
                        $this->registerJs('(function () {buildConstructionTimeline(reservations, "timeline");})();', View::POS_END);
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
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    <a href="#" class="reminder-link pull-right create-notification" data-construction-id="<?= $model->id ?>">Уведомить, когда освободится</a>
                </div>
            </div>
            <div class="row buttons-row block-row">
                <div class="col-md-12">
                    <button type="button" id="buy-btn" class="custom-btn sm blue" data-action-type="buyConstruction">Купить</button>
                    <?php if (!$isEmployee) { ?>
                        <button type="button" id="reserv-btn" class="custom-btn sm blue" data-action-type="reservConstruction">Отложить на 5 дней</button>
                    <?php } ?>
                    <button type="button" class="custom-btn sm white" id="goBack">Вернуться назад</button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div id="map" style="height: 450px; width: 100%"></div>
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
                    <?php } ?>
                    <?php if (AdvertisingConstructionForm::getLightsType($model->type_id, $model->size_id) != null) { ?>
                    <div class="details-row">
                        <p><span class="bold">Тип подсветки:</span> <?php echo AdvertisingConstructionForm::getLightsType($model->type_id, $model->size_id); ?></p>
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
        goBackBtn = $('#goBack'),
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
    goBackBtn.on('click', goBack);

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function goBack() {
        var q = window.location.href.split('&q=');
        var url = '/construction/index';
        console.log(q);
        if (q.length > 1) {
             url = url + '?' + q[1];
        }

        window.location.href = url;
    }

    function showRequireAuthorizationModal() {
        $('#requireAuthorization').modal('show');
    }
    
    function buyConstruction() {
        if (!!isGuest) {
            showRequireAuthorizationModal();
            return;
        }
        
        if (isEmployee) {
            $('#company-selection').modal('show');
            return;
        }
        
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

