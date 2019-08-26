<?php

namespace app\services;

use app\models\entities\CarouselImage;
use app\modules\admin\models\CarouselItemForm;

class CarouselService
{
    public function saveCarouselItem($viewModel) {
        $entity = $viewModel->id != null ?
          CarouselImage::findOne($viewModel->id) :
          new CarouselImage();

        $entity->order = $viewModel->order;
        if ($viewModel->path != null) {
          $entity->path = '/'.$viewModel->path;
        }

        $entity->save();
        return $entity;
    }

    public function getCarouselItemForm($entity) {
        $model = new CarouselItemForm();
        $model->id= $entity->id;
        $model->path = $entity->path;
        $model->order = $entity->order;
        $model->isNewRecord = false;
        return $model;
    }
}