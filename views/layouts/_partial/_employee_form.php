<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm*/
/* @var $form ActiveForm */
if($model->user_id == Yii::$app->user->getId()) {
    $buttonText = 'Сохранить изменения';
} else {
    $buttonText = 'Зарегистрировать';
}
?>

<div class="employee">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'id' => 'create-employee-form',
            'options' => ['enctype' => 'multipart/form-data'],
            'validationUrl' => \yii\helpers\Url::toRoute('/admin/user/validate-signup')
        ]); ?>

        <?= $form->field($model, 'surname')->textInput([
            'label' => 'Фамилия',
            'placeholder' => 'Фамилия сотрудника',
            'tabindex' => '1',
        ])
        ?>

        <?= $form->field($model, 'name')->textInput([
            'label' => 'Имя',
            'placeholder' => 'Имя сотрудника',
            'tabindex' => '2',
        ])
        ?>

        <?= $form->field($model, 'lastname')->textInput([
            'label' => 'Отчество',
            'placeholder' => 'Отчество сотрудника',
            'tabindex' => '3',
        ])
        ?>

        <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput([
            'placeholder' => 'Введите рабочий e-mail',
            'tabindex' => '4',
        ])
        ?>

        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Не менее 8 символов',
            'tabindex' => '5',
        ])
        ?>

        <?= $form->field($model, 'number')->textInput([
            'label' => 'Телефон',
            'placeholder' => '+375 (__) ___ __ __',
            'tabindex' => '6',
        ])
        ?>


        <div class="row">
            <div class="col-md-7">
                <div class="preview" id="image-preview" <?= !empty($model->photo) ? 'style="background-image: url(\'/'.$model->photo.'\')"' : '' ?>>

                </div>
            </div>
            <div class="col-md-5">
                <button type="button" class="btn custom-btn gray full-width" onclick="$('#signupform-photo').click()">Загрузить фотографию</button>
                <div class="preview small" id="image-spreview" <?= !empty($model->photo) ? 'style="background-image: url(\'/'.$model->photo.'\')"' : '' ?> >

                </div>
                <?= $form->field($model, 'photo')->fileInput([
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

        <?= $form->field($model, 'user_id')->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'scenario')->hiddenInput()->label(false); ?>
        <div class="row">
            <div class="col-md-8">
                <?= Html::submitButton($buttonText, ['class' => 'btn custom-btn full-width primary text-uppercase'])?>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn custom-btn gray full-width text-uppercase" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
