<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 12:33 AM
 */


use app\models\constants\AdvertisingConstructionStatuses;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $ordersDataProvider yii\data\ArrayDataProvider */
/* @var $user app\models\User */

$this->title = $user->company;
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
                                    $result .= ' '.(new DateTime($model->created_at))->format('d.m');
                                }

                                return '<span class="'. $className .'">'.$result.'</span>';
                            }
                        ],
                        [
                            'label' => 'Даты использования',
                            'headerOptions' => ['class' => 'text-center', 'width' => '250'],
                            'contentOptions' =>['class' => 'text-center'],
                            'value' => function ($model) {
                                return $model->from.' - '.$model->to;
                            }
                        ],
                        [
                            'label' => 'Стоимость',
                            'headerOptions' => ['width' => '120', 'class' => 'text-center'],
                            'contentOptions' =>['class' => 'text-center'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->status_id == AdvertisingConstructionStatuses::IN_PROCESSING || $model->status_id == AdvertisingConstructionStatuses::RESERVED ?
                                    '<input class="form-control full-width cost" type="text" value="'.$model->cost.'" />' :
                                    $model->cost;
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{confirm}{cancel}',
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
        $('.approve-order').on('click', function () {
            var data = $(this).data();
            data.cost = $(this).closest('tr').find('.cost').val();
            colorApp.utilities.ajaxHelper.post({
                url: GATEWAY_URLS.APPROVE_ORDER,
                data: data
            }).done(function (result) {
                window.location.reload();
            });
        });
    });
</script>
<?= $this->render('@app/views/layouts/_partial/_modalClientData', [
    'title' => 'Изменить данные компании',
    'scenario' => \app\models\SignupForm::SCENARIO_EmployeeEditClient
]);
?>