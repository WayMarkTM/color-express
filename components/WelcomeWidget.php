<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 14.05.2017
 * Time: 18:31
 */

namespace app\components;


use app\models\User;
use app\services\UserService;
use yii\base\Widget;

class WelcomeWidget extends Widget
{
    public function run() {
        $userService = new UserService();

        return $this->render('_welcome', [
            'name' => $userService->getUserName(\Yii::$app->user->getId())
        ]);
    }
}