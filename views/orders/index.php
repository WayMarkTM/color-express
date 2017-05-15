<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 7:37PM
 */

use app\models\constants\AdvertisingConstructionStatuses;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */


$this->title = 'Мои заказы';
?>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-uppercase">Мои заказы</h3>
    </div>
</div>
<div class="row block-row">
    <div class="col-md-12">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
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
                    'value' => function ($model) {
                        $result = $model->status->name;

                        if ($model->status_id == AdvertisingConstructionStatuses::RESERVED || $model->status_id == AdvertisingConstructionStatuses::APPROVED_RESERVED) {
                            $result .= ' '.(new DateTime($model->created_at))->format('d.m');
                        }

                        return $result;
                    }
                ],
                [
                    'label' => 'Даты использования',
                    'headerOptions' => ['class' => 'text-center', 'width' => '250'],
                    'contentOptions' =>['class' => 'text-center'],
                    'value' => function ($model) {
                        return (new DateTime($model->from))->format('d.m.Y').' - '.(new DateTime($model->to))->format('d.m.Y');
                    }
                ],
                [
                    'attribute' => 'cost',
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
                            return Html::a('Купить', ['construction/details?id='.$model->advertisingConstruction->id], [
                                'title' => 'Купить',
                                'class' => 'custom-btn sm blue',
                                'style' => 'width: 50%;'.($model->status_id != AdvertisingConstructionStatuses::RESERVED && $model->status_id != AdvertisingConstructionStatuses::APPROVED_RESERVED ? 'display:none' : '')
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
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>

<script type="text/javascript">
    $('.cancel-order-button').on('click', function () {
        toastr.warning('Свяжитесь, пожалуйста, с Вашим менеджером.');
    })
</script>