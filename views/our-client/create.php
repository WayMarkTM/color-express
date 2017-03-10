<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\OurClientForm */

$this->title = 'Добавить клиента';
$this->params['breadcrumbs'][] = ['label' => 'Our Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-container">
    <div class="page-content">
        <div class="our-client-create">

            <h1><?= Html::encode($this->title) ?></h1>

            <div class="row">
                <div class="col-md-4">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => 'Название компании *']) ?>
                    <?= $form->field($model, 'imageFile')->fileInput() ?>

                    <button class="btn btn-primary">Создать</button>

                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>