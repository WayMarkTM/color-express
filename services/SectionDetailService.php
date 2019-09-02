<?php

namespace app\services;

use app\models\entities\SectionDetail;
use app\modules\admin\models\SectionDetailForm;

class SectionDetailService
{
    public function saveItem($viewModel) {
        $entity = $viewModel->id != null ?
          SectionDetail::findOne($viewModel->id) :
          new SectionDetail();

        $entity->section_id = $viewModel->section_id;
        $entity->formatted_text = $viewModel->formatted_text;
        $entity->order = $viewModel->order;
        $entity->link_to = $viewModel->link_to;
        $entity->link_text = $viewModel->link_text;
        $entity->link_icon = $viewModel->link_icon;

        if ($viewModel->path != null) {
          $entity->image_path = '/'.$viewModel->path;
        }

        $entity->save();
        return $entity;
    }

    public function getForm($entity) {
        $model = new SectionDetailForm();
        $model->id= $entity->id;
        $model->path = $entity->image_path;
        $model->section_id = $entity->section_id;
        $model->formatted_text = $entity->formatted_text;
        $model->order = $entity->order;
        $model->link_to = $entity->link_to;
        $model->link_text = $entity->link_text;
        $model->link_icon = $entity->link_icon;
        $model->isNewRecord = false;
        return $model;
    }
}