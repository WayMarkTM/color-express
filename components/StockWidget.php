<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 28.04.2017
 * Time: 17:55
 */

namespace app\components;


use app\models\StockSettings;
use app\services\SiteSettingsService;
use yii\base\Widget;

class StockWidget extends Widget
{
    private $cookieName = 'stock';

    public function run()
    {
        $model = new StockSettings();

        if (!isset($_COOKIE[$this->cookieName])) {
            $model = $this->getStockModel();
            setcookie($this->cookieName, true, time() + intval($model->frequency), "/");
        }

        return $this->render('_stock', [
            'model' => $model
        ]);
    }

    private function getStockModel() {
        $service = new SiteSettingsService();

        return $service->getStockSettings();
    }
}