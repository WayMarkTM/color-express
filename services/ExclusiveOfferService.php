<?php

namespace app\services;

use app\models\entities\ExclusiveOfferPage;
use app\modules\admin\models\ExclusiveOfferForm;

class ExclusiveOfferService
{
    public function saveItem($viewModel) {
        $entity = $viewModel->id != null ?
          ExclusiveOfferPage::findOne($viewModel->id) :
          new ExclusiveOfferPage();

        $entity->title = $viewModel->title;
        $entity->formatted_text = $viewModel->formatted_text;
        $entity->facebook_title = $viewModel->facebook_title;
        if ($viewModel->path != null) {
          $entity->image_path = '/'.$viewModel->path;
        }

        $entity->save();
        return $entity;
    }

    public function getItemForm($entity) {
        $model = new ExclusiveOfferForm();
        $model->id= $entity->id;
        $model->title = $entity->title;
        $model->formatted_text = $entity->formatted_text;
        $model->facebook_title = $entity->facebook_title;
        $model->path = $entity->image_path;
        return $model;
    }
}