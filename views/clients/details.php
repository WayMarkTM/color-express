<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 12:33 AM
 */


use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $ordersDataProvider yii\data\ArrayDataProvider */
/* @var $company app\models\ClientModel */

$this->title = $company->company;
?>

<ul class="nav nav-tabs" id="control-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Заказы</a></li>
    <li role="presentation"><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Документы</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel" id="orders">
        <div class="row">
            <div class="col-md-12">
                <?php Pjax::begin(); ?>
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
                            'attribute' => 'advertisingConstructionName',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'value' => function ($model) {
                                return Html::a($model->advertisingConstructionName, ['advertising-construction/details?id='.$model->id]);
                            }
                        ],
                        [
                            'attribute' => 'address',
                            'headerOptions' => ['class' => 'text-center']
                        ],
                        [
                            'attribute' => 'type',
                            'headerOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'attribute' => 'status',
                            'headerOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Даты использования',
                            'headerOptions' => ['class' => 'text-center', 'width' => '250'],
                            'contentOptions' =>['class' => 'text-center'],
                            'value' => function ($model) {
                                return $model->dateFrom->format('d.m.Y').' - '.$model->dateTo->format('d.m.Y');
                            }
                        ],
                        [
                            'attribute' => 'cost',
                            'headerOptions' => ['width' => '120', 'class' => 'text-center'],
                            'contentOptions' =>['class' => 'text-center'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{confirm}{cancel}',
                            'header' => 'Управление',
                            'headerOptions' => ['width' => '300', 'class' => 'text-center'],
                            'contentOptions' =>['class' => 'text-center'],
                            'buttons' => [
                                'confirm' => function ($url ,$model) {
                                    return Html::a('Подтвердить', '/', [
                                        'title' => 'Подтвердить',
                                        'class' => 'custom-btn sm blue',
                                        'style' => 'width:50%;'.($model->status == 'Резерв до' ? '' : 'display: none;')
                                    ]);
                                },
                                'cancel' => function ($url, $model) {
                                    return Html::a('Отклонить', '/', [
                                        'title' => 'Отклонить',
                                        'class' => 'custom-btn sm white',
                                        'style' => 'width:50%;'.($model->status != 'Резерв до' ? 'display: none;' : '')
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
    <div clasa="tab-pane" role="tabpanel" id="documents">

    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="important-content text-uppercase"><?php echo $company->company; ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="#" class="additional-link"><i class="icon edit-icon"></i>Редактировать данные</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon phone-icon"></i><?php echo $company->name ?></h4>
                    <div class="info-block-content internal">
                        <p>+375 17 399-10-95/96/97</p>
                        <p>+375 29 199-27-89</p>
                        <p>+375 44 742-59-21</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon email-icon"></i>Email:</h4>
                    <div class="info-block-content internal">
                        <p><?php echo $company->email; ?></p>
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
                        <p>г. Минск, ул. Железнодорожная, 44</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon info-icon"></i>Информация:</h4>
                    <div class="info-block-content internal">
                        <p><?php echo $company->type; ?></p>
                        <p>Договор №384 от 20.08.2014 г.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery('#control-tabs').find('a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show')
    });
</script>