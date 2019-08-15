<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\LoginForm;
use yii\helpers\Url;

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
            if(Yii::$app->user->can('admin')) {
                Yii::$app->getResponse()->redirect(Url::toRoute('/admin/construction/index'));
            } elseif(Yii::$app->user->can('employee')) {
                Yii::$app->getResponse()->redirect(Url::toRoute('/clients/index'));
            } else {
                Yii::$app->getResponse()->redirect(Url::toRoute('/construction/index'));
            }
        }
        return $this->render('_signin', [
            'auth_form' => $this->authForm,
        ]);
    }

}