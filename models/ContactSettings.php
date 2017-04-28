<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 28.04.2017
 * Time: 16:43
 */

namespace app\models;

/**
 * @property $phones array|string
 * @property $email string
 * @property $address string
 * @property $latitude string
 * @property $longitude string
 */
class ContactSettings
{
    public $phones;
    public $email;
    public $address;
    public $latitude;
    public $longitude;
}