<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 10.03.2017
 * Time: 13:23
 */

namespace app\services;

use app\models\entities\OurClient;

class OurClientService
{
    public function saveOurClient($viewModel) {
        $newEntity = new OurClient();
        $newEntity->name = $viewModel->name;
        $newEntity->logo_url = $viewModel->path;
        $newEntity->save();
        return $newEntity;
    }
}