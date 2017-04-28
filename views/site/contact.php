<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
/* @var $contactSettings app\models\ContactSettings */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;

$coord = new LatLng(['lat' => $contactSettings->latitude, 'lng' => $contactSettings->longitude]);

$map = new Map([
    'center' => $coord,
    'zoom' => 17,
    'width' => '100%',
    'height' => '365'
]);

$marker = new Marker([
    'position' => $coord,
    'title' => 'Колорэкспресс',
]);

$marker->attachInfoWindow(
    new InfoWindow([
        'content' => '<p>'.$contactSettings->address.'</p>'
    ])
);

$map->addOverlay($marker);
?>

<div class="row">
    <div class="col-sm-12">
        <?php echo $map->display(); ?>
    </div>
</div>
<div class="row section-row">
    <div class="col-sm-4">
        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
            Ваше сообщение отправлено. Мы свяжемся с Вами в ближайшее время.
        <?php else: ?>
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => 'Ваше имя *'])->label(false) ?>
            <?= $form->field($model, 'phone')->textInput(['placeholder' => '+375 (__) ___-__-__ *'])->label(false) ?>
            <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => 'Ваше сообщение (до 2000 символов)'])->label(false) ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'custom-btn primary full-width', 'name' => 'contact-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-12">
                <p class="note-message">Свяжитесь с нами любым удобным для вас способом, и мы ответим на все интересующие вас вопросы!</p>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header"><i class="icon phone-icon"></i>Контакты для связи: </h4>
                    <div class="info-block-content">
                        <?php foreach($contactSettings->phones as $phone) {
                            echo '<p>'.$phone.'</p>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header"><i class="icon email-icon"></i>Email: </h4>
                    <div class="info-block-content">
                        <p><?php echo $contactSettings->email; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header"><i class="icon address-icon"></i>Наш адрес: </h4>
                    <div class="info-block-content">
                        <p><?php echo $contactSettings->address; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>