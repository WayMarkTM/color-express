<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 06.04.2017
 * Time: 2:02
 */

namespace app\components;

use Yii;
use yii\base\Widget;
use app\services\UserService;

class BadgeWidget extends Widget
{
    public static $NEW_USER_COUNT = 1;
    public $param;

    public function run()
    {
        $count = 0;
        switch($this->param) {
            case self::$NEW_USER_COUNT:
                $count = UserService::getContNewClients();
                break;
            default:
                $count = 0;
                break;
        }

        return $this->render('_badge', [
            'count' => $count,
        ]);
    }

}