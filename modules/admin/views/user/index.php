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
                <div class="employee">
                        <div class="row">
                            <?php $form = ActiveForm::begin([
                                'id' => 'create-employee-form',
                                'options' => ['enctype' => 'multipart/form-data'],
                                'validationUrl' => \yii\helpers\Url::toRoute('/admin/user/validate-signup')
                            ]); ?>

                            <?= $form->field($employee, 'surname')->textInput([
                                'label' => 'Фамилия',
                                'placeholder' => 'Фамилия сотрудника',
                                'tabindex' => '1',
                            ])
                            ?>

                            <?= $form->field($employee, 'name')->textInput([
                                'label' => 'Имя',
                                'placeholder' => 'Имя сотрудника',
                                'tabindex' => '2',
                            ])
                            ?>

                            <?= $form->field($employee, 'lastname')->textInput([
                                'label' => 'Отчество',
                                'placeholder' => 'Отчество сотрудника',
                                'tabindex' => '3',
                            ])
                            ?>

                            <?= $form->field($employee, 'username', ['enableAjaxValidation' => true])->textInput([
                                'placeholder' => 'Введите рабочий e-mail',
                                'tabindex' => '4',
                            ])
                            ?>

                            <?= $form->field($employee, 'password')->passwordInput([
                                'placeholder' => 'Не менее 8 символов',
                                'tabindex' => '5',
                            ])
                            ?>

                            <?= $form->field($employee, 'number')->textInput([
                                'label' => 'Телефон',
                                'placeholder' => '+375 (__) ___ __ __',
                                'tabindex' => '6',
                            ])
                            ?>


                            <div class="row">
                                <div class="col-md-7">
                                    <div class="preview" id="image-preview">

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <button type="button" class="btn custom-btn gray full-width" onclick="$('#signupform-photo').click()">Загрузить фотографию</button>
                                    <div class="preview small" id="image-spreview">

                                    </div>
                                    <?= $form->field($employee, 'photo')->fileInput([
                                        'class' => 'hide',
                                        'accept' => 'image/*'
                                    ])->label(false) ?>
                                </div>
                            </div>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $.uploadPreview({
                                        input_field: "#signupform-photo",
                                        preview_box: "#image-preview, #image-spreview",
                                        no_label: true
                                    });
                                });
                            </script>

                            <div class="row">
                                <div class="col-md-8">
                                    <?= Html::submitButton('Зарегистрировать', ['class' => 'btn custom-btn full-width primary text-uppercase'])?>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn custom-btn gray full-width text-uppercase" data-dismiss="modal">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
            </div>
        </div>

    </div>
</div>
