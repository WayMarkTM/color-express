<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\ExclusiveOfferPage */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Управление страницей Exclusive Offer', 'url' => ['index']];
?>
<div class="exclusive-offer-page-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'custom-btn blue']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Содержимое',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->formatted_text;
                }
            ],
            [
                'label' => 'Изображение',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<img src="'.$model->image_path.'" />';
                }
            ],
            'title',
            'facebook_title',
        ],
    ]) ?>

</div>
