<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use app\models\EmployeeModel;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider
 * @var $employee EmployeeModel*/

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/app/jquery.uploadPreview.min.js');
?>
<div class="user-index">

    <h3><?= Html::encode($this->title) ?>
        <a href="#" class="custom-btn blue" data-toggle="modal" data-target="#register">Добавить сотрудника</a>

    </h3>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'surname',
            'lastname',
            'username',
            'number',


            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index, $this) {
                    return \yii\helpers\Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ]
    ]); ?>
<?php Pjax::end(); ?></div>

<div id="register" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-uppercase"><strong>Регистрация сотрудника</strong></h4>
                </div>
            </div>
            <div class="modal-body">
                <?= $this->render('@app/views/layouts/_partial/_employee_form', [
                    'modal' => $employee
                ]);
                ?>
            </div>
        </div>

    </div>
</div>
