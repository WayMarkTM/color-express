<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\PageMetadata */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Мета-данные о страницах', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-metadata-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'custom-btn blue']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'key',
            'title',
            'description',
            'keywords',
        ],
    ]) ?>

</div>
