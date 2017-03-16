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

?>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-uppercase">Корзина</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
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
                    'label' => 'Даты использования',
                    'headerOptions' => ['class' => 'text-center', 'width' => '250'],
                    'contentOptions' =>['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->dateFrom->format('d.m.Y').' - '.$model->dateTo->format('d.m.Y');
                    }
                ],
                [
                    'attribute' => 'cost',
                    'headerOptions' => ['width' => '100', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                ],
                [
                    'attribute' => 'marketingType',
                    'headerOptions' => ['class' => 'text-center', 'width' => '180'],
                    'contentOptions' =>['class' => 'text-center'],
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
