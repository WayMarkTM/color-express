<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\OurClient */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Управление нашими клиентами', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="our-client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'custom-btn blue']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'custom-btn red',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого клиента?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'logo_url:url',
        ],
    ]) ?>

</div>
