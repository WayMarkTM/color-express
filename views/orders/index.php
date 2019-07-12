<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 7:37PM
 */

use dimmitri\grid\ExpandRowColumn;
use app\components\BadgeWidget;
use app\models\constants\AdvertisingConstructionStatuses;
use app\models\constants\SystemConstants;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $isAgency boolean */


$this->title = 'Мои заказы';
?>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-uppercase">Мои заказы</h3>
    </div>
</div>
<div class="row block-row">
    <div class="col-md-12">
        <?php
            $columns = [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['width' => '30', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                ],
                [
                    'attribute' => 'advertisingConstruction.name',
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return Html::a($model->advertisingConstruction->name, ['construction/details?id='.$model->advertisingConstruction->id]);
                    }
                ],
                [
                    'attribute' => 'advertisingConstruction.address',
                    'headerOptions' => ['class' => 'text-center']
                ],
                [
                    'attribute' => 'advertisingConstruction.type.name',
                    'headerOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute' => 'status.name',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                    'label' => 'Статус',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $className = '';
                        $result = $model->status->name;

                        if ($model->status_id == AdvertisingConstructionStatuses::DECLINED) {
                            $className = 'highlight-declined';
                        }

                        if ($model->status_id == AdvertisingConstructionStatuses::APPROVED || $model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED) {
                            $className = 'highlight-approved';
                        }

                        if ($model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED) {
                            $className = 'highlight-processing';
                        }

                        if ($model->status_id == AdvertisingConstructionStatuses::APPROVED) {
                            foreach ($model->advertisingConstructionReservationPeriods as $period) {
                                if (new \DateTime($period->to) > new \DateTime()) {
                                    $result = 'Текущий';
                                }
                            }

                            if ($result != 'Текущий') {
                                $result = 'Завершенный';
                            }
                        }

                        if ($model->status_id == AdvertisingConstructionStatuses::RESERVED || $model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED) {
                            $result .= ' '.(new \DateTime($model->reserv_till))->format('d.m');
                        }

                        return '<span class="'. $className .'">'.$result.'</span>';
                    }
                ],
                [
                    'class' => ExpandRowColumn::class,
                    'label' => 'Даты использования',
                    'headerOptions' => ['class' => 'text-center', 'width' => '210'],
                    'contentOptions' => function ($model) {
                        if (count($model->advertisingConstructionReservationPeriods) > 1) {
                            return ['class' => 'text-center'];
                        }

                        return ['class' => 'text-center not-unwrappable'];                                
                    },
                    'value' => function ($model) {
                        $firstPeriod = $model->advertisingConstructionReservationPeriods[0];
                        $lastPeriod = $model->advertisingConstructionReservationPeriods[count($model->advertisingConstructionReservationPeriods) - 1];
                        $borderTotalDays = (new \DateTime($lastPeriod->to))->diff(new \DateTime($firstPeriod->from))->days;
                        $totalDays = -1;
                        foreach ($model->advertisingConstructionReservationPeriods as $period) {
                            $totalDays += (new \DateTime($period->to))->diff(new \DateTime($period->from))->days + 1;
                        }

                        if ($borderTotalDays == $totalDays) {
                            return (new \DateTime($firstPeriod->from))->format('d.m.Y').' - '.(new \DateTime($lastPeriod->to))->format('d.m.Y');
                        }
                        
                        return '- (подробнее)';
                    },
                    'url' => Url::to(['row-details']),
                ],
                [
                    'attribute' => 'advertisingConstruction.price',
                    'header' => $isAgency ? 'Прайсовая цена в день, с НДС (BYN) для бел./иностр. ТМ' : 'Цена в день, с НДС (BYN) для бел./иностр. ТМ',
                    'headerOptions' => ['width' => '120', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                ],
                [
                    'attribute' => 'cost',
                    'header' => $isAgency ? 'Стоимость со скидкой за период, с НДС (BYN) для бел./иностр. ТМ' : 'Стоимость за период, с НДС (BYN) для бел./иностр. ТМ',
                    'headerOptions' => ['width' => '120', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{buy}{buyAgain}{cancel}',
                    'header' => 'Управление',
                    'headerOptions' => ['width' => '300', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                    'buttons' => [
                        'buy' => function ($url ,$model) {
                            return Html::a('Купить', ['shopping-cart/index'], [
                                'title' => 'Купить',
                                'class' => 'custom-btn sm blue buy-reserved-construction',
                                'data-id' => $model->id,
                                'style' => 'width: 50%;'.($model->status_id != AdvertisingConstructionStatuses::APPROVED_RESERVED  ? 'display:none' : '')
                            ]);
                        },
                        'buyAgain' => function ($url, $model) {
                            return Html::a('Купить повторно', ['construction/details?id='.$model->advertisingConstruction->id], [
                                'title' => 'Купить повторно',
                                'class' => 'custom-btn sm blue',
                                'style' => 'width: '.($model->status_id == AdvertisingConstructionStatuses::APPROVED || $model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED || $model->status_id == AdvertisingConstructionStatuses::DECLINED ? '100%' : '50%').';'.($model->status_id == AdvertisingConstructionStatuses::RESERVED || $model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED ? 'display:none' : '')
                            ]);
                        },
                        'cancel' => function ($url, $model) {
                            return Html::a('Отменить', '#', [
                                'title' => 'Отменить',
                                'class' => 'custom-btn sm white cancel-order-button',
                                'style' => 'width:50%;'.($model->status_id != AdvertisingConstructionStatuses::IN_PROCESSING && $model->status_id != AdvertisingConstructionStatuses::RESERVED && $model->status_id != AdvertisingConstructionStatuses::APPROVED_RESERVED ? 'display: none;' : '')
                            ]);
                        }
                    ]
                ],
            ];

            if ($isAgency) {
                $stockPrice = array([
                    'label' => 'Стоимость в день со скидкой, с НДС (BYN) для бел./иностр. ТМ',
                    'headerOptions' => ['width' => '120', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                    'value' => function ($model) {
                        $from = new \DateTime($model->from);
                        $to = new \DateTime($model->to);
                        $interval = date_diff($to, $from);

                        return number_format($model->cost / (intval($interval->days) + 1), 2, ".", "");
                    }
                ]);

                array_splice($columns, 7, 0, $stockPrice);
            }
        ?>

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'columns' => $columns,
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>

<script type="text/javascript">
    /* Disable unwrappping rows for reservations with only 1 period */
    $('tr td.not-unwrappable span').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

    $('.cancel-order-button').on('click', function () {
        toastr.warning('Свяжитесь, пожалуйста, с Вашим менеджером.');
    });

    $('.buy-reserved-construction').on('click', function () {
        var data = $(this).data();

        colorApp.utilities.ajaxHelper.post({
            url: GATEWAY_URLS.BUY_RESERVED_CONSTRUCTION,
            data: data
        }).done(function (result) {
            if (result.isValid) {
                window.location.href = '/shopping-cart/index';
            } else {
                toastr.error("Произошла ошибка. Свяжитесь с Вашим администратором.");
            }
        });
    });
</script>