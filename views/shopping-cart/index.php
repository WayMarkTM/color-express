<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/16/2017
 * Time: 7:37PM
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $submitCartModel app\models\AdvertisingConstructionSearch */
/* @var $cartTotal integer */

$this->title = 'Корзина';
?>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-uppercase">Корзина</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')) { ?>
            Ваш заказ отправлен.
        <?php } ?>

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}',
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
                        return Html::a($model->advertisingConstruction->name, ['advertising-construction/details?id='.$model->advertisingConstruction->id]);
                    }
                ],
                [
                    'attribute' => 'advertisingConstruction.address',
                    'headerOptions' => ['class' => 'text-center']
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
                    'attribute' => 'cost',
                    'headerOptions' => ['width' => '120', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                ],
                [
                    'label' => 'Тип рекламы',
                    'headerOptions' => ['class' => 'text-center', 'width' => '180'],
                    'contentOptions' =>['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->marketingType->name;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{removeFromCart}',
                    'headerOptions' => ['width' => '180'],
                    'contentOptions' =>['class' => 'text-center'],
                    'buttons' => [
                        'removeFromCart' => function ($url ,$model) {
                            return Html::a('Удалить из корзины', 'shopping-cart/delete?id='.$model->id, [
                                'title' => 'Удалить из корзины',
                                'class' => 'custom-btn sm white'
                            ]);
                        }
                    ]
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-inline']]) ?>
    <div class="row block-row">
        <div class="col-md-4">
            <span class="shopping-cart-total">Итого: <span class="total-cost"><?php echo $cartTotal; ?></span> бел. руб. с НДС</span>
        </div>
        <div class="col-md-8">
            <div class="pull-right">
                <?= $form->field($submitCartModel, 'thematic')->textInput(['placeholder' => 'Например: телефоны', 'style' => 'width: 300px; margin-left: 15px'])->label('Укажите, пожалуйста, тематику сюжета:') ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row block-row">
        <div class="col-md-4 col-md-offset-4">
            <?= Html::submitButton('Подтвердить', ['class' => 'custom-btn blue full-width']) ?>
        </div>
    </div>

<?php ActiveForm::end() ?>
