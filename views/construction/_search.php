<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 14.03.2017
 * Time: 13:07
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\AdvertisingConstructionSearch */
/* @var $sizes array app\models\entities\AdvertisingConstructionSize */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertising-construction-search">
    <div class="row">
        <div class="col-md-12 bold">
            Фильтр рекламных конструкций:
        </div>
    </div>
    <hr/>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'labelOptions' => ['class' => 'col-sm-3 control-label'],
            'enableError' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'type_id')->hiddenInput()->label('') ?>
    <?= $form->field($model, 'size_id')->dropDownList($sizes, ['prompt' => 'Выберите размер'])->label('По размеру:') ?>
    <?= $form->field($model, 'address')->textInput(['placeholder' => 'Независимости проспект, 80'])->label('По адресу:') ?>
    <?php
    $rangeLayout = '<div class="form-group"><label class="col-sm-3 control-label">По датам: </label>'.
        '<div class="col-sm-6">'.
        '<span class="range-prefix">с </span>{input1}'.
        '</div></div><div class="form-group"><div class="col-sm-offset-3 col-sm-6">'.
        '<span class="range-prefix">по </span>{input2}'.
        '</div></div>';

    echo DatePicker::widget([
        'type' => DatePicker::TYPE_RANGE,
        'name' => 'fromDate',
        'attribute' => 'fromDate',
        'name2' => 'toDate',
        'attribute2' => 'toDate',
        'layout' => $rangeLayout,
        'form' => $form,
        'model' => $model,
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'dd.mm.yyyy'
        ]
    ]);
    ?>

    <?= $form->field($model, 'showOnlyFreeConstructions')->checkbox([
        'label' => 'Показать только свободные конструкции',
        'selected' => $model->showOnlyFreeConstructions
    ]) ?>


    <div class="form-group">
        <div class="col-sm-12">
            <?= Html::submitButton('Отобрать', ['class' => 'custom-btn sm white full-width']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>