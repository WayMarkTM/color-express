<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\LoginForm;

class AuthWidget extends Widget
{
    /* @var LoginForm*/
    public $authForm;

    public function init()
    {
        parent::init();
        $this->authForm = new LoginForm();
    }

    public function run()
    {
        if($this->authForm->load(Yii::$app->request->post()) && $this->authForm->login()) {
            Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
        }
        return $this->render('_signin', [
            'auth_form' => $this->authForm,
        ]);
    }

}