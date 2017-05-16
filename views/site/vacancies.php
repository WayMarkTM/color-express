<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 13.02.2017
 * Time: 18:55
 */

/* @var $clients array app\models\entities\OurClient */
/* @var $feedBackForm app\models\FeedBackForm */

$this->title = "Вакансии";

?>

<div class="row">
    <div class="col-md-6">
        <?php
            $i = 0;
            foreach($vacancies as $vacancy) { ?>
                <div class="row <?php echo $i == 0 ? '' : 'section-row'?>">
                    <div class="col-md-12">
                        <h4 class="text-uppercase bold"><?php echo $vacancy->title; ?></h4>
                        <hr/>
                        <p><?php echo $vacancy->content; ?></p>
                    </div>
                </div>
            <?php $i++; }
        ?>
    </div>
    <div class="col-md-offset-1 col-md-5">
        <div class="row">
            <div class="col-md-12">
                <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
                    Ваше сообщение отправлено. Мы свяжемся с Вами в ближайшее время.
                <?php else: ?>
                    <h4 class="text-uppercase bold">Обратная связь</h4>
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'feedback-form',
                        'options' => ['enctype' => 'multipart/form-data'],
                    ])
                    ?>
                    <?= $form->field($feedBackForm, 'name')->textInput([
                        'placeholder' => 'Ваше имя *'
                    ]) -> label(false);
                    ?>
                    <?= $form->field($feedBackForm, 'phone')->textInput([
                        'placeholder' => '+375 (__) ___ __ __'
                    ]) -> label(false);
                    ?>
                    <?= $form->field($feedBackForm, 'email')->textInput([
                        'placeholder' => 'Ваш e-mail *'
                    ]) -> label(false);
                    ?>

                    <div class="form-group">
                        <label for="feedbackform-upload_resume" class="btn custom-btn blue form-control">Загрузить резюме</label>
                    </div>
                    <?= $form->field($feedBackForm, 'upload_resume')->fileInput([
                        'class' => 'hide',
                    ])->label(false) ?>

                    <?= $form->field($feedBackForm, 'message')->textarea([
                        'placeholder' => 'Ваше сообщение (до 2000 символов)',
                        'rows' => 5
                    ]) -> label(false);
                    ?>
                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn custom-btn primary form-control text-uppercase']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>