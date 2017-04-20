<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 13.03.2017
 * Time: 22:57
 */

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\SignupForm;
use app\services\UserService;

class SignupWidget extends Widget
{
    /* @var $signupForm SignupForm*/
    public $signupForm;

    public function init()
    {
        parent::init();
        $this->signupForm = new SignupForm();
    }

    public function run()
    {
        if (isset($_POST['SignupForm'])) {
            $this->signupForm->setAttributes($_POST['SignupForm'], false);
            $userService = new UserService();
            $userService->save($this->signupForm);
            Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
        }
        return $this->render('_signup', [
            'model' => $this->signupForm
        ]);
    }

}