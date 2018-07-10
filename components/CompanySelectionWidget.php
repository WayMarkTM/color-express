<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 01.05.2017
 * Time: 15:06
 */

namespace app\components;

use yii;
use app\services\ClientsService;
use yii\base\Widget;

class CompanySelectionWidget extends Widget
{
    public $param;

    public function run()
    {
        $service = new ClientsService();

        $managerId = null;
        if (Yii::$app->user->can('employee')) {
            $managerId = Yii::$app->user->getId();
        }
        $allClients = $service->getClients();

        return $this->render('_companySelection', [
            'clients' => $allClients,
            'manageId' => $managerId,
            'multiple' => $this->param == 'multiple'
        ]);
    }

}