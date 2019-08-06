<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 28.04.2017
 * Time: 16:42
 */

namespace app\services;


use app\models\constants\SiteSettingKey;
use app\models\ContactSettings;
use app\models\entities\SiteSettings;
use app\models\StockSettings;

class SiteSettingsService
{
    /**
     * @return ContactSettings
     */
    public function getContactSettings() {
        $model = new ContactSettings();

        $model->email = SiteSettings::findOne(SiteSettingKey::CONTACT_EMAIL)->value;
        $model->address = SiteSettings::findOne(SiteSettingKey::ADDRESS)->value;
        $model->latitude = SiteSettings::findOne(SiteSettingKey::ADDRESS_LAT)->value;
        $model->longitude = SiteSettings::findOne(SiteSettingKey::ADDRESS_LONG)->value;
        $model->instagram = SiteSettings::findOne(SiteSettingKey::INSTAGRAM)->value;
        $model->facebook = SiteSettings::findOne(SiteSettingKey::FACEBOOK)->value;
        $model->leftPhones = explode(";", SiteSettings::findOne(SiteSettingKey::CONTACT_LEFT_PHONES)->value);
        $model->rightPhones = explode(";", SiteSettings::findOne(SiteSettingKey::CONTACT_RIGHT_PHONES)->value);

        return $model;
    }

    /**
     * @return StockSettings
     */
    public function getStockSettings() {
        $model = new StockSettings();

        $model->frequency = SiteSettings::findOne(SiteSettingKey::STOCK_FREQUENCY)->value;
        $model->content = SiteSettings::findOne(SiteSettingKey::STOCK_CONTENT)->value;

        return $model;
    }

    public static function isShowStock()
    {
        return !!SiteSettings::findOne(SiteSettingKey::STOCK_SHOW)->value;
    }

    public static function getContactEmail() {
        return SiteSettings::findOne(SiteSettingKey::CONTACT_EMAIL)->value;
    }
}