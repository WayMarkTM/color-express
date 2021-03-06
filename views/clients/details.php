<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 12:33 AM
 */


use app\components\InterruptReservationWidget;
use app\models\constants\AdvertisingConstructionStatuses;
use app\models\constants\SystemConstants;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $ordersDataProvider yii\data\ArrayDataProvider */
/* @var $user app\models\User */

$this->title = $user->company;

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
                                if ($model->status_id == AdvertisingConstructionStatuses::DECLINED) {
                                    $className = 'highlight-declined';
                                }

                                if ($model->status_id == AdvertisingConstructionStatuses::APPROVED || $model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED) {
                                    $className = 'highlight-approved';
                                }

                                if ($model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED) {
                                    $className = 'highlight-processing';
                                }

                                $result = $model->status->name;

                                if ($model->status_id == AdvertisingConstructionStatuses::RESERVED || $model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED) {
                                    $result .= ' '.(new DateTime($model->reserv_till))->format('d.m');
                                }

                                return '<span class="'. $className .'">'.$result.'</span>';
                            }
                        ],
                        [
                            'label' => 'Даты использования',
                            'headerOptions' => ['class' => 'text-center', 'width' => '220'],
                            'contentOptions' =>['class' => 'text-center'],
                            'value' => function ($model) {
                                return $model->from.' - '.$model->to;
                            }
                        ],
                        [
                            'label' => 'Стоимость в день, BYN ',
                            'headerOptions' => ['width' => '140', 'class' => 'text-center'],
                            'contentOptions' =>['class' => 'text-center'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                $from = new \DateTime($model->from);
                                $to = new \DateTime($model->to);
                                $interval = intval(date_diff($to, $from)->days) + 1;

                                $price = $model->cost / $interval;

                                return $model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED ?
                                    '<input class="form-control full-width price-per-day" data-period="'.$interval.'" type="text" value="'.number_format($price, 2, ".", "").'" />' :
                                    number_format($price, 2, ".", "");
                            }
                        ],
                        [
                            'label' => 'Стоимость за период, BYN',
                            'headerOptions' => ['width' => '140', 'class' => 'text-center'],
                            'contentOptions' =>['class' => 'text-center cost'],
                            'attribute' => 'cost'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{confirm}{cancel}{interrupt}{delete}',
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
        $('.price-per-day').on('change', function (e) {
            var price = $(this).val(),
                period = $(this).data('period'),
                $cost = $(this).closest('tr').find('.cost');

            $cost.text(price*period);
        });

        $('.approve-order').on('click', function () {
            var data = $(this).data(),
                $pricePerDay = $(this).closest('tr').find('.price-per-day');
            data.cost = $pricePerDay.val() * $pricePerDay.data('period');
            colorApp.utilities.ajaxHelper.post({
                url: GATEWAY_URLS.APPROVE_ORDER,
                data: data
            }).done(function (result) {
                window.location.reload();
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