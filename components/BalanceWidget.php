<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 5/16/2017
 * Time: 2:56 PM
 */

namespace app\components;


use app\services\UserService;
use yii\base\Widget;

class BalanceWidget extends Widget
{
    public function run() {
        $userService = new UserService();

        return $this->render('_balance', [
            'balance' => $userService->getUserBalance(\Yii::$app->user->getId())
        ]);
    }
}