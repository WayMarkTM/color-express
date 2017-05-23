<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 22.05.2017
 * Time: 21:16
 */

namespace app\components;

use app\models\ForgotPassForm;
use \Yii;
use app\models\LoginForm;
use yii\base\Widget;

class ForgotPassWidget extends Widget
{
    public function run()
    {
        $forgotPassForm = new ForgotPassForm();
        if($forgotPassForm->load(Yii::$app->request->post()) && $forgotPassForm->validate()) {
            if($forgotPassForm->forgotPass()) {
                Yii::$app->session->setFlash('resetSuccess');
                $forgotPassForm = new LoginForm();
            }
        }
        return $this->render('_forgot_pass', [ 'forgotPassForm' => $forgotPassForm]);
    }
}