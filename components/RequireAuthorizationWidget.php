<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 01.05.2017
 * Time: 14:18
 */

namespace app\components;


use yii\base\Widget;

class RequireAuthorizationWidget extends Widget
{
    public function run()
    {
        return $this->render('_requireAuthorization');
    }
}