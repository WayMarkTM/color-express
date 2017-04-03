<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\entities\User */
/* @var $form ActiveForm */
?>

<div id="signup" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-uppercase"><strong>Регистрация</strong></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                            <?php $form = ActiveForm::begin([
                            'id' => 'signup-form',
                            'options' => ['class' => ''],
                            'validationUrl' => Url::toRoute('admin/user/validate-signup')
                        ]); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'company')->textInput([
                                    'label' => 'Название компании',
                                    'placeholder' => 'Название компании',
                                    'tabindex' => '1',
                                ])
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'address')->textInput([
                                    'label' => 'Адрес',
                                    'placeholder' => 'Адрес Вашей организации',
                                    'tabindex' => '8',
                                ])
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput([
                                    'label' => 'Имя',
                                    'placeholder' => 'Имя',
                                    'tabindex' => '2',
                                ])
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'pan')->textInput([
                                    'label' => 'УНП',
                                    'placeholder' => 'Введите 9 символов',
                                    'tabindex' => '9',
                                ])
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'number')->textInput([
                                    'label' => 'Телефон',
                                    'placeholder' => '+375 (__) ___ __ __',
                                    'tabindex' => '3',
                                ])
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'okpo')->textInput([
                                    'label' => 'ОКПО',
                                    'placeholder' => 'Введите 8 символов',
                                    'tabindex' => '10',
                                ])
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput([
                                    'placeholder' => 'Введите рабочий e-mail',
                                    'tabindex' => '4',
                                ])
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'checking_account')->textInput([
                                    'label' => 'Р/С',
                                    'placeholder' => 'Расчетный счет Вашей компании',
                                    'tabindex' => '11',
                                ])
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'password')->passwordInput([
                                    'placeholder' => 'Не менее 8 символов',
                                    'tabindex' => '5',
                                ])
                                ?>
                                <?= $form->field($model, 'sec_password')->passwordInput([
                                    'placeholder' => 'Не менее 8 символов',
                                    'tabindex' => '6',
                                ])
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'bank')->textarea([
                                    'label' => 'Банк',
                                    'placeholder' => 'Наименование и БИК обслуживающего банка',
                                    'rows' => '5',
                                    'tabindex' => '12',
                                ])
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'is_agency')->dropDownList([
                                    '0' => 'Рекламное агенство',
                                    '1' => 'Конечный заказчик'
                                ], [
                                    'tabindex' => '7',
                                ])
                                ?>
                            </div>
                            <div class="col-md-6">
                                <label>&nbsp;</label>
                                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn custom-btn primary form-control text-uppercase']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <h5 class="pull-left">Все поля обязательны для заполнения</h5>
            </div>
        </div>

    </div>
</div>
