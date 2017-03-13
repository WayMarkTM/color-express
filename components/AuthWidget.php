<?php

namespace app\components;

use yii\base\Widget;
use app\models\LoginForm;

class AuthWidget extends Widget
{
    public $authForm;

    public function init()
    {
        parent::init();
        $this->authForm = new LoginForm();
    }

    public function run()
    {
        if (isset($_POST['LoginForm'])) {
            $this->authForm->attributes = $_POST['LoginForm'];
            $this->authForm->login();
            \Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
        }
        return $this->render('_signin', [
            'auth_form' => $this->authForm
        ]);
    }

}