<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 17.03.2017
 * Time: 2:02
 */

namespace app\models;

use yii\base\Model;


class FeedBackForm extends Model
{
    public $name;
    public $number;
    public $email;
    public $upload_resume;
    public $message;


}