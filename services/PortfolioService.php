<?php

namespace app\services;

use app\models\entities\PortfolioItem;
use app\modules\admin\models\PortfolioItemForm;

class PortfolioService
{
    public function savePortfolioItem($viewModel) {
        $entity = $viewModel->id != null ?
          PortfolioItem::findOne($viewModel->id) :
          new PortfolioItem();

        $entity->title = $viewModel->title;
        if ($viewModel->path != null) {
          $entity->image_url = $viewModel->path;
        }

        $entity->save();
        return $entity;
    }

    public function getPortfolioItemForm($entity) {
        $model = new PortfolioItemForm();
        $model->id= $entity->id;
        $model->path = $entity->image_url;
        $model->title = $entity->title;
        $model->isNewRecord = false;
        return $model;
    }
}