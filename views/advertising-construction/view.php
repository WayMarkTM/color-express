<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 13.03.2017
 * Time: 15:09
 */

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\entities\AdvertisingConstruction */
/* @var $reservationModel app\models\AdvertisingConstructionFastReservationForm */


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
?>

<div class="advertising-construction-details">
    <div class="row">
        <div class="col-md-8">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-12">
                    <div style="height: 500px;">PHOTOS SLIDER</div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    Панель: Забронировано, свободно
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12">
                    Календарь
                </div>
            </div>
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
                    <a href="#" class="reminder-link pull-right">Уведомить, когда освободится</a>
                </div>
            </div>
            <div class="row buttons-row block-row">
                <div class="col-md-12">
                    <button type="button" class="custom-btn sm blue">Купить</button>
                    <button type="button" class="custom-btn sm blue">Отложить на 5 дней</button>
                    <?= Html::a('Вернуться назад', ['/advertising-construction/index'], ['class'=>'custom-btn sm white']) ?>
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
                    <div class="details-row">
                        <p><span class="bold">Рядом расположены:</span> <?php echo $model->nearest_locations; ?></p>
                    </div>
                    <div class="details-row">
                        <p><span class="bold">Трафик:</span> <?php echo $model->traffic_info; ?></p>
                    </div>
                    <div class="details-row">
                        <p><span class="bold">Светофоры:</span> <?php echo $model->has_traffic_lights ? 'есть' : 'нет'; ?></p>
                    </div>
                    <div class="details-row">
                        <a href="#">Скачать технические требования для печати плаката.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

