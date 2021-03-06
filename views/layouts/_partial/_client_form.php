<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm*/
/* @var $form ActiveForm */
?>

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
                    'placeholder' => '+375 (29) ___ __ __, +375 (17) ___ __ __, ...',
                    'tabindex' => '3',
                ])
                ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'okpo')->textInput([
                    'label' => 'ОКПО',
                    'placeholder' => 'Не более 20 символов',
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
                    'rows' => $model->getScenario() == $model::SCENARIO_EmployeeEditClient ? '1' : '5',
                    'tabindex' => '12',
                ])
                ?>

                <?php if ($model->getScenario() == $model::SCENARIO_EmployeeEditClient) { ?>
                    <?= $form->field($model, 'balance')->textInput([
                        'label' => 'Задолженность',
                        'placeholder' => 'Задолженность клиента',
                        'tabindex' => '13',
                    ])
                    ?>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php if(!Yii::$app->user->getId() || Yii::$app->user->getId() != $model->user_id): ?>
                    <?= $form->field($model, 'is_agency')->dropDownList([
                        '1' => 'Рекламное агентство',
                        '0' => 'Конечный заказчик'
                    ], [
                        'tabindex' => '7',
                    ])
                    ?>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'user_id')->hiddenInput()->label(false); ?>
                <?= $form->field($model, 'scenario')->hiddenInput()->label(false); ?>
                    <label>&nbsp;</label>
                <?php if(!Yii::$app->user->isGuest && ($model->getScenario() == $model::SCENARIO_EmployeeEditClient || Yii::$app->user->getId() == $model->user_id)): ?>
                    <div class="col-md-7">
                        <?= Html::submitButton('Сохранить изменения', ['class' => 'btn custom-btn sm primary text-uppercase'])?>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn custom-btn gray sm text-uppercase" data-dismiss="modal">Отмена</button>
                    </div>
                <?php elseif(Yii::$app->user->can('employee') && $model->getScenario() == $model::SCENARIO_DEFAULT): ?>
                    <?= Html::submitButton('Зарегистрировать клиента', ['class' => 'btn custom-btn sm primary text-uppercase']) ?>
                <?php elseif($model->getScenario() == $model::SCENARIO_DEFAULT): ?>
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn custom-btn sm primary text-uppercase']) ?>
                <?php elseif($model->getScenario() == $model::SCENARIO_EmployeeApplySignup): ?>
                    <div class="col-md-7">
                        <?= Html::submitButton('Подтвердить регистрацию', ['class' => 'btn custom-btn sm blue text-uppercase']) ?>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn custom-btn sm gray text-uppercase" data-dismiss="modal">Отмена</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>