<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\entities\SiteSettings */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки Сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-settings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'value',
            'name',
        ],
    ]) ?>

</div>
