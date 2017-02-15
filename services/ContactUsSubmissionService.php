<?php

/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 15.02.2017
 * Time: 18:08
 */
namespace app\services;

use app\models\entities\ContactUsSubmission;

class ContactUsSubmissionService
{
    public function createContactSubmission($viewModel) {
        $now = new \DateTime();

        $newEntity = new ContactUsSubmission();
        $newEntity->name = $viewModel->name;
        $newEntity->phone = $viewModel->phone;
        $newEntity->message = $viewModel->body;
        $newEntity->email = "";
        $newEntity->submitted_at = $now->format('Y\-m\-d\ h:i:s');;

        $newEntity->save();
    }
}