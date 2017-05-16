<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 13.03.2017
 * Time: 22:57
 */

namespace app\components;

use app\services\MailService;
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
            $user = $userService->save($this->signupForm);
            if($user) {
                $userRole = Yii::$app->authManager->getRole('client');
                Yii::$app->authManager->assign($userRole, $user->getId());

                $mailService = new MailService();

                $mailService->sendSignUpUser($user);
            }
            Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
        }
        return $this->render('_signup', [
            'model' => $this->signupForm
        ]);
    }

}