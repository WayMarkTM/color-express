<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 13.03.2017
 * Time: 22:57
 */

namespace app\components;

use yii\base\Widget;
use app\models\SignupForm;

class SignupWidget extends Widget
{
    public $signupForm;

    public function init()
    {
        parent::init();
        $this->signupForm = new SignupForm();
    }

    public function run()
    {
        if (isset($_POST['SignupForm'])) {
            $this->signupForm->attributes = $_POST['SignupForm'];
            $this->signupForm->login();
            \Yii::$app->getResponse()->redirect(\Yii::$app->getRequest()->getUrl());
        }
        return $this->render('_signup', [
            'model' => $this->signupForm
        ]);
    }

}