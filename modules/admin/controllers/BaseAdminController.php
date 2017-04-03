<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 17.03.2017
 * Time: 12:40
 */

namespace app\modules\admin\controllers;

use yii\web\Controller;

abstract class BaseAdminController extends Controller
{
    public function beforeAction($action)
    {
        $this->layout = 'admin.php';
        return parent::beforeAction($action);
    }
}