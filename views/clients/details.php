<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 12:33 AM
 */

use dimmitri\grid\ExpandRowColumn;
use app\components\InterruptReservationWidget;
use app\models\constants\AdvertisingConstructionStatuses;
use app\models\constants\SystemConstants;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $ordersDataProvider yii\data\ArrayDataProvider */
/* @var $user app\models\User */

$this->title = $user->company;

$this->registerJsFile('@web/js/ui-bootstrap-tpls-2.5.0.min.js');

InterruptReservationWidget::begin();
InterruptReservationWidget::end();
?>

<div class="row">
    <div class="col-md-7">
        <ul class="nav nav-tabs" id="control-tabs">
            <li role="presentation" class="active"><a href="#orders">Заказы</a></li>
            <li role="presentation"><a href="<?php echo Url::toRoute('clients/details-documents?clientId='.$user->id); ?>">Документы</a></li>
        </ul>
    </div>
    <div class="col-md-5 text-right">
        <span class="balance-label">
            Сумма задолженности <?php echo $user->is_agency ? 'общая' : ''; ?> (BYN):
            <span class="balance-value">
                <?php echo $user->balance == null ? 0 : $user->balance; ?>
            </span>
        </span>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel" id="orders">
        <div class="row">
            <div class="col-md-12">
                <?= GridView::widget([
                    'dataProvider' => $ordersDataProvider,
                    'layout' => '{items}{pager}',
                    'columns' => [
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
                            'label' => 'Сюжет',
                            'headerOptions' => ['class' => 'text-center', 'width' => '150'],
                            'contentOptions' =>['class' => 'text-center'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<input class="form-control thematic" style="width: calc(100% - 20px); display: inline;" data-id="'.$model->id.'" data-original-value="'.$model->thematic.'" type="text" value="'.$model->thematic.'" />
                                    <a class="submit-thematic" href="#" style="display: none;"><span style="color: #164a9e" class="glyphicon glyphicon-ok"></span></a>
                                ';
                            }
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
                            'headerOptions' => ['class' => 'text-center', 'width' => '260'],
                            'contentOptions' => function ($model) {
                                if (count($model->advertisingConstructionReservationPeriods) > 1) {
                                    return ['class' => 'text-center'];
                                }

                                return ['class' => 'text-center not-unwrappable'];                                
                            },
                            'format' => 'raw',
                            'value' => function ($model) {
                                $periods = $model->getAdvertisingConstructionReservationPeriods()
                                    ->orderBy('from ASC')
                                    ->all();
                                $firstPeriod = $periods[0];
                                $lastPeriod = $periods[count($periods) - 1];
                                $borderTotalDays = (new \DateTime($lastPeriod->to))->diff(new \DateTime($firstPeriod->from))->days;
                                $totalDays = -1;
                                foreach ($periods as $period) {
                                    $totalDays += (new \DateTime($period->to))->diff(new \DateTime($period->from))->days + 1;
                                }

                                if (count($periods) == 1 &&
                                    ($model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED ||
                                    ($model->status_id == AdvertisingConstructionStatuses::APPROVED && new \DateTime($model->to) > new \DateTime()))) {
                                    $rangeLayout = '<div class="row"><div class="col-md-6" style="padding-right: 5px">'.
                                        '{input1}'.
                                        '</div><div class="col-md-6" style="padding-left: 5px">'.
                                        '{input2}'.
                                        '</div></div>';
                
                                    return DatePicker::widget([
                                        'type' => DatePicker::TYPE_RANGE,
                                        'name' => 'from',
                                        'attribute' => 'from',
                                        'name2' => 'to',
                                        'attribute2' => 'to',
                                        'layout' => $rangeLayout,
                                        'value' => (new \DateTime($model->from))->format('d.m.Y'),
                                        'value2' => (new \DateTime($model->to))->format('d.m.Y'),
                                        'options' => [
                                            'class' => 'date-from'
                                        ],
                                        'options2' => [
                                            'class' => 'date-to'
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'todayHighlight' => true,
                                            'format' => 'dd.mm.yyyy'
                                        ]
                                    ]);
                                }
        
                                if ($borderTotalDays == $totalDays) {
                                    return (new \DateTime($firstPeriod->from))->format('d.m.Y').' - '.(new \DateTime($lastPeriod->to))->format('d.m.Y');
                                }
                                
                                return '- (подробнее)';
                            },
                            'submitData' => function ($model, $key, $index) {
                                return [
                                    'id' => $model->id,
                                    'constructionId' => $model->advertising_construction_id,
                                    'isEditable' => $model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED ||
                                        ($model->status_id == AdvertisingConstructionStatuses::APPROVED && new \DateTime($model->to) > new \DateTime())
                                ];
                            },
                            'url' => Url::to(['row-details']),
                        ],
                        [
                            'label' => 'Цена в день, с НДС (BYN) для бел./иностр. ТМ',
                            'headerOptions' => ['width' => '140', 'class' => 'text-center'],
                            'contentOptions' =>['class' => 'text-center'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                if (count($model->advertisingConstructionReservationPeriods) > 1) {
                                    return '-';
                                }

                                $from = new \DateTime($model->from);
                                $to = new \DateTime($model->to);
                                $interval = intval(date_diff($to, $from)->days) + 1;

                                $price = number_format($model->cost / $interval, 2, ".", "");

                                return $model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED ||
                                    ($model->status_id == AdvertisingConstructionStatuses::APPROVED && new \DateTime($model->to) > new \DateTime()) ?
                                    '<input class="form-control full-width price-per-day" data-period="'.$interval.'" type="text" value="'.$price.'" />' :
                                    $price;
                            }
                        ],
                        [
                            'label' => 'Стоимость за период, с НДС (BYN) для бел./иностр. ТМ',
                            'headerOptions' => ['width' => '140', 'class' => 'text-center'],
                            'contentOptions' =>['class' => 'text-center cost'],
                            'attribute' => 'cost'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{confirm}{buy}{cancel}{interrupt}{delete}',
                            'header' => 'Управление',
                            'headerOptions' => ['width' => '300', 'class' => 'text-center'],
                            'contentOptions' =>['class' => 'text-center'],
                            'buttons' => [
                                'confirm' => function ($url ,$model) {
                                    return Html::a('Подтвердить', '#', [
                                        'title' => 'Подтвердить',
                                        'class' => 'custom-btn sm blue approve-order',
                                        'data-user-id' => $model->user_id,
                                        'data-id' => $model->id,
                                        'style' => 'width:50%;'.($model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED ? '' : 'display: none;')
                                    ]);
                                },
                                'buy' => function ($url, $model) {
                                    return Html::a('Купить', '#', [
                                        'title' => 'Купить',
                                        'class' => 'custom-btn sm blue buy-reservation',
                                        'style' => 'width: 50%;'.($model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED ? '' : 'display:none;'),
                                        'data-id' => $model->id
                                    ]);
                                },
                                'cancel' => function ($url, $model) {
                                    return Html::a('Отклонить', ['clients/decline-order?clientId='.$model->user_id.'&orderId='.$model->id], [
                                        'title' => 'Отклонить',
                                        'class' => 'custom-btn sm white',
                                        'style' => 'width:50%;'.($model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED  ? '' : 'display: none;')
                                    ]);
                                },
                                'interrupt' => function ($url, $model) {
                                    return Html::a('Прервать', '#', [
                                        'title' => 'Прервать',
                                        'class' => 'custom-btn sm white interrupt-reservation',
                                        'style' => 'width: 50%;'.($model->status_id == AdvertisingConstructionStatuses::APPROVED && new \DateTime($model->to) > new \DateTime()  ? '' : 'display:none;'),
                                        'data-id' => $model->id,
                                        'data-from' => $model->from,
                                        'data-to' => $model->to,
                                        'data-cost' => $model->cost
                                    ]);
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a('Удалить', '#', [
                                        'title' => 'Удалить',
                                        'class' => 'custom-btn sm red delete-reservation',
                                        'style' => 'width: 50%;'.($model->status_id == AdvertisingConstructionStatuses::APPROVED || $model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED ? '' : 'display:none;'),
                                        'data-id' => $model->id
                                    ]);
                                }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="important-content text-uppercase"><?php echo $user->company; ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="#" class="additional-link client-editable" data-user-id="<?= $user->id ?>"><i class="icon edit-icon"></i>Редактировать данные</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon phone-icon"></i><?php echo $user->name ?></h4>
                    <div class="info-block-content internal">
                        <p><?php echo $user->number; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon email-icon"></i>Email:</h4>
                    <div class="info-block-content internal">
                        <p><?php echo $user->username; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon address-icon"></i>Адрес:</h4>
                    <div class="info-block-content internal">
                        <p><?php echo $user->address; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon info-icon"></i>Информация:</h4>
                    <div class="info-block-content internal">
                        <p><?php echo $user->getType(); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        Date.prototype.addDays = function(days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }

        /* Disable unwrappping rows for reservations with only 1 period */
        $('tr td.not-unwrappable span').on('click', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });

        $('.thematic').on('keyup', function (e) {
            var confirmationLink = $(this).closest('td').find('.submit-thematic');
            confirmationLink.attr('style', 'display: inline;');
        });

        $('.submit-thematic').on('click', function (e) {
            var $cell = $(this).closest('td'),
                submitModel = {
                    id: $cell.find('.thematic').data('id'),
                    thematic: $cell.find('.thematic').val()
                },
                $link = $(this);

            colorApp.utilities.ajaxHelper.post({
                url: GATEWAY_URLS.UPDATE_THEMATIC,
                data: submitModel
            }).done(function (result) {
                $link.attr('style', 'display: none');    
                toastr.success('Сюжет успешно обновлен');
            });            
        })

        function calculatePeriod($dateFrom, $dateTo) {
            if ($dateFrom == null || $dateTo == null) {
                return $(this).data('period');
            }

            var format = 'DD.MM.YYYY';
            return moment($dateTo.val(), format).diff(moment($dateFrom.val(), format), 'days') + 1;
        }

        function onDateOrPriceChanged(e) {
            var price = $(this).closest('tr').find('.price-per-day').val(),
                period = calculatePeriod($(this).closest('tr').find('.date-from'), $(this).closest('tr').find('.date-to')),
                $cost = $(this).closest('tr').find('.cost');

            $cost.text((price*period).toFixed(2));
        }

        $('.price-per-day').on('change', onDateOrPriceChanged);
        $('.date-from').on('change', onDateOrPriceChanged);
        $('.date-to').on('change', onDateOrPriceChanged);

        $('.approve-order').on('click', function () {
            var data = $(this).data(),
                $cost = $(this).closest('tr').find('.cost'),
                dateFrom = $(this).closest('tr').find('.date-from').val(),
                dateTo = $(this).closest('tr').find('.date-to').val();
                
            data.cost = $cost.html();
            if (dateFrom != null && dateTo != null) {
                var formatFrom = 'DD.MM.YYYY',
                    formatTo = 'YYYY-MM-DD';
                data.from = moment(dateFrom, formatFrom).format(formatTo);
                data.to = moment(dateTo, formatFrom).format(formatTo);
            }

            colorApp.utilities.ajaxHelper.post({
                url: GATEWAY_URLS.APPROVE_ORDER,
                data: data
            }).done(function (result) {
                if (result.success) {
                    window.location.reload();
                } else {
                    toastr.error(result.message);
                }
            });
        });

        $('.interrupt-reservation').on('click', function (e) {
            e.preventDefault();
            var data = $(this).data();
            $('#interrupt-reservation-modal #interruptionform-id').val(data.id);
            $('#interrupt-reservation-modal #interruptionform-todate').val(data.to);
            $('#interrupt-reservation-modal #interruptionform-cost').val(data.cost);
            $('#interrupt-reservation-modal').modal('show');

        });

        $('.buy-reservation').on('click', function (e) {
            e.preventDefault();
            var data = $(this).data();
            colorApp.utilities.ajaxHelper.post({
                url: GATEWAY_URLS.BUY_RESERVATION,
                data: data
            }).done(function (result) {
                if (result.success) {
                    window.location.href = '/shopping-cart/index';
                } else {
                    toastr.error('Произошла ошибка.');
                }
            }).catch(function () {
                toastr.error('Произошла ошибка.');
            });
        });

        $('.delete-reservation').on('click', function (e) {
            e.preventDefault();
            var data = $(this).data();
            if (confirm('Вы уверены, что хотите удалить бронирование/резерв?')) {
                colorApp.utilities.ajaxHelper.post({
                    url: GATEWAY_URLS.DELETE_ORDER,
                    data: data
                }).done(function (result) {
                    window.location.reload();
                });
            }
        })
    });
</script>
<?= $this->render('@app/views/layouts/_partial/_modalClientData', [
    'title' => 'Изменить данные компании',
    'scenario' => \app\models\SignupForm::SCENARIO_EmployeeEditClient
]);
?>