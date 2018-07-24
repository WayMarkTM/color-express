<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 01.05.2017
 * Time: 18:14
 */
use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $timelinesItems mixed */


$position = View::POS_BEGIN;
$this->registerJsFile('@web/js/vis.min.js');
$this->registerJs('var timelines = '.json_encode($timelinesItems).';', $position);
$this->title = "Сводка";
?>

<link rel="stylesheet" href="/web/styles/vis.min.css" />

<div class="row">
    <div class="col-sm-2" style="width: 12%">
        <h3 class="text-uppercase">Сводка</h3>
    </div>
    <div class="col-sm-4" style="padding: 0; width: 46%">
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-inline'
            ]
        ]) ?>
            <?= Html::dropDownList("manager", $manager, $managers, [
                'class' => 'form-control',
                'style' => 'width: 25%'
            ]); ?>

            <?= Html::input('text', 'client', $client, [
                'class' => 'form-control',
                'style' => 'width: 25%',
                'placeholder' => 'Клиент'
            ]) ?>

            <?= Html::input('text', 'address', $address, [
                'class' => 'form-control full-width',
                'style' => 'width: 25%',
                'placeholder' => 'Адрес'
            ]) ?>

            <?= Html::submitButton('Поиск', ['class' => 'custom-btn sm blue', 'style' => 'width: 80px']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-sm-6 text-right" style="width: 42%">
        <div class="status-panel">
            <div class="item">
                <span class="indicator booked"></span><span class="text"> - Куплено</span>
            </div>
            <div class="item">
                <span class="indicator reserved"></span><span class="text"> - Отложено</span>
            </div>
            <div class="item">
                <span class="indicator free"></span><span class="text"> - Свободно</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div id="timeline"></div>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <button type="button" class="custom-btn blue full-width" id="backToFilter">Вернуться назад к фильтру</button>
    </div>
</div>

<?php
    $this->registerJsFile('@web/js/app/summary-timeline.js');
?>