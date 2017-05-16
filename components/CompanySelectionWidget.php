<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 01.05.2017
 * Time: 15:06
 */

namespace app\components;

use app\services\ClientsService;
use yii\base\Widget;

class CompanySelectionWidget extends Widget
{
    public $param;

    public function run()
    {
        $service = new ClientsService();
        return $this->render('_companySelection', [
            'clients' => $service->getClients(),
            'multiple' => $this->param == 'multiple'
        ]);
    }

}