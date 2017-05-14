<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 14.05.2017
 * Time: 17:16
 */

namespace app\components;


use app\services\UserService;
use yii\base\Widget;

class ManagerWidget extends Widget
{
    public function run() {
        $userService = new UserService();
        $manager = $userService->getManager(\Yii::$app->user->getId());

        return $this->render('_manager', [
            'manager' => $manager
        ]);
    }
}