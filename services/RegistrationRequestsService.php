<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 3/17/2017
 * Time: 2:17 AM
 */

namespace app\services;


use app\models\RegistrationRequestModel;

class RegistrationRequestsService
{
    public function getRequests() {
        return array(
            new RegistrationRequestModel(1, 'ОАО "Колор экспо Минск"', new \DateTime('2016-05-11 11:00:00'), 'Агенство'),
            new RegistrationRequestModel(2, 'ОАО "Колор экспо Минск"', new \DateTime('2016-05-11 11:00:00'), 'Заказчик'),
            new RegistrationRequestModel(3, 'ОАО "Колор экспо Минск"', new \DateTime('2016-05-11 11:00:00'), 'Агенство'),
            new RegistrationRequestModel(4, 'ОАО "Колор экспо Минск"', new \DateTime('2016-05-11 11:00:00'), 'Заказчик'),
            new RegistrationRequestModel(5, 'ОАО "Колор экспо Минск"', new \DateTime('2016-05-11 11:00:00'), 'Заказчик'),
            new RegistrationRequestModel(6, 'ОАО "Колор экспо Минск"', new \DateTime('2016-05-11 11:00:00'), 'Агенство'),
            new RegistrationRequestModel(7, 'ОАО "Колор экспо Минск"', new \DateTime('2016-05-11 11:00:00'), 'Заказчик'),
        );
    }
}