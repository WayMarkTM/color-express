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
        $model->phones = explode(";", SiteSettings::findOne(SiteSettingKey::PHONES)->value);

        return $model;
    }
}