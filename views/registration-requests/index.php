<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 2:23 AM
 */


use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */


$this->title = 'Новые заявки';
?>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-uppercase">Новые заявки</h3>
    </div>
</div>
<div class="row block-row">
    <div class="col-md-12">
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
                    'attribute' => 'company',
                    'headerOptions' => ['class' => 'text-center']
                ],
                [
                    'attribute' => 'timestamp',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center', 'width' => '220'],
                    'value' => function ($model) {
                        return $model->timestamp->format('d.m.Y H:i');
                    }
                ],
                [
                    'label' => 'Информация',
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'text-center', 'width' => '250'],
                    'contentOptions' =>['class' => 'text-center'],
                    'value' => function ($model) {
                        return Html::a('Регистрационные данные', '#', ['class' => 'client-editable', 'data-user-id' => $model->id]);
                    }
                ],
                [
                    'attribute' => 'type',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center', 'width' => '150'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<div class="form-group">{confirm}</div>{decline}',
                    'header' => 'Управление',
                    'headerOptions' => ['width' => '300', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                    'buttons' => [
                        'confirm' => function ($url ,$model) {
                            $url = \yii\helpers\Url::toRoute(['confirm-registration', 'id' => $model->id]);
                            return Html::a('Подтвердить регистрацию', $url, [
                                'title' => 'Подтвердить регистрацию',
                                'class' => 'custom-btn sm blue full-width',
                            ]);
                        },
                        'decline' => function ($url ,$model) {
                            $url = \yii\helpers\Url::toRoute(['/clients/delete', 'id' => $model->id]);
                            return Html::a('Удалить заявку', $url, [
                                'title' => 'Удалить заявку',
                                'class' => 'custom-btn sm red full-width',
                            ]);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>
<?= $this->render('@app/views/layouts/_partial/_modalClientData', [
    'title' => 'Регистрационные данные компании',
    'scenario' => \app\models\SignupForm::SCENARIO_EmployeeApplySignup
]);
?>
