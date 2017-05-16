<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 12:14 AM
 */

use app\components\BadgeWidget;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $employeeList [] */

$this->title = 'Управление клиентами';
?>
<div class="row">
    <div class="col-md-6">
        <h3 class="text-uppercase">
            Список клиентов
            <button style="margin-left: 30px;" class="custom-btn blue" type="button">Добавить клиента</button>
        </h3>
    </div>
    <div class="col-md-6">
        <?= Html::input('text', 'search', '', [
            'class' => 'form-control full-width',
            'style' => 'margin-top: 10px;',
            'placeholder' => 'Введите данные для поиска'
        ]) ?>
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
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return '<a href="/clients/details?clientId='.$model->id.'">'.$model->company.'</a> '.BadgeWidget::widget([
                            'param' => BadgeWidget::$CLIENTS_LIST_UNPROCCESSED_ORDERS_COUNT,
                            'paramId' => $model->id
                        ]);
                    }
                ],
                [
                    'attribute' => 'name',
                    'headerOptions' => ['class' => 'text-center']
                ],
                [
                    'attribute' => 'phone',
                    'headerOptions' => ['class' => 'text-center', 'width' => '180'],
                    'contentOptions' =>['class' => 'text-center'],
                ],
                [
                    'attribute' => 'email',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                ],
                [
                    'attribute' => 'type',
                    'headerOptions' => ['class' => 'text-center', 'width' => '100'],
                    'contentOptions' =>['class' => 'text-center'],
                ],
                [
                    'attribute' => 'responsiblePerson',
                    'format' => 'raw',
                    'headerOptions' => ['width' => '150', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                    'value' => function ($model) {
                        //return '<select class="form-control"><option value="'.$model->responsiblePerson.'">'.$model->responsiblePerson.'</option></select>';
                        return Html::dropDownList("Employes", $model->responsiblePerson, $model->employes, [
                            'class' => 'form-control',
                            'onchange' => 'updateManager(this)',
                            'data-user-id' => $model->id,
                        ]);
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} &nbsp;&nbsp;&nbsp;{delete}',
                    'headerOptions' => ['width' => '80', 'class' => 'text-center'],
                    'contentOptions' =>['class' => 'text-center'],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return  Html::a('','#', ['class' => 'glyphicon glyphicon-pencil client-editable', 'data-user-id' => $model->id]);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>

<script type="text/javascript">
    function updateManager(user) {
        debugger;
        document.location.href='<?=Url::to(['update-manager'])?>?id=' + $(user).data('user-id') + '&manager_id=' +  user.value;
    }
</script>
<?= $this->render('@app/views/layouts/_partial/_modalClientData', [
    'title' => 'Изменить данные компании',
    'scenario' => \app\models\SignupForm::SCENARIO_EmployeeEditClient
]);
?>