<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<?php Pjax::begin(['id' => "pjax-{$id}", 'enablePushState' => false]); ?>

<?= GridView::widget([
  'dataProvider' => $dataProvider,
  'layout' => '{items}',
  'columns' => [
    [
      'label' => 'С',
      'headerOptions' => ['class' => 'text-center'],
      'contentOptions' =>['class' => 'text-center'],
      'value' => function ($model) {
        return $model->from;
      }
    ],
    [
      'label' => 'По',
      'headerOptions' => ['class' => 'text-center'],
      'contentOptions' =>['class' => 'text-center'],
      'value' => function ($model) {
        return $model->to;
      }
    ],
    [
      'label' => 'Стоимость в день, BYN',
      'headerOptions' => ['class' => 'text-center'],
      'contentOptions' =>['class' => 'text-center'],
      'value' => function ($model) {
        return number_format($model->price, 2, ".", "");
      }
    ],
    [
      'label' => 'Стоимость за период, BYN',
      'headerOptions' => ['class' => 'text-center'],
      'contentOptions' =>['class' => 'text-center'],
      'value' => function ($model) {
        $fromDate = new \DateTime($model->from);
        $toDate = new \DateTime($model->to);
        $days = intval($fromDate->diff($toDate)->days + 1);
        return number_format($model->price * $days, 2, ".", "");
      }
    ]
  ]
]) ?>

<?php Pjax::end(); ?>