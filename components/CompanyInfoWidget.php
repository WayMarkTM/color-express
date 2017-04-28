<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 28.04.2017
 * Time: 16:53
 */

namespace app\components;


use app\services\SiteSettingsService;
use yii\base\Widget;

class CompanyInfoWidget extends Widget
{
    public function run()
    {
        $siteSettingsService = new SiteSettingsService();
        $model = $siteSettingsService->getContactSettings();

        return $this->render('_companyInfo', [
            'model' => $model
        ]);
    }
}