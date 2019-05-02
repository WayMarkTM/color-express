<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\entities\PageMetadata */

$this->title = 'Создание мета-данных о странице';
$this->params['breadcrumbs'][] = ['label' => 'Мета-данные о страницах', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-metadata-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
