<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 28.04.2017
 * Time: 16:43
 */

namespace app\models;

/**
 * @property $leftPhones array|string
 * @property $rightPhones array|string
 * @property $email string
 * @property $address string
 * @property $latitude string
 * @property $longitude string
 * @property $instagram string
 * @property $facebook string
 */
class ContactSettings
{
    public $leftPhones;
    public $rightPhones;
    public $phones;
    public $email;
    public $address;
    public $latitude;
    public $longitude;
    public $instagram;
    public $facebook;
}