<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 14.05.2017
 * Time: 23:00
 */

namespace app\models;


class Mail
{
    private $from = 'color_admin@gmail.com';

    public function send($form, $to, $subject) {
        //\Yii::$app->mailer->compose('contact/html', ['contactForm' => $form])
        \Yii::$app->mailer->compose()
            ->setFrom($this->from)
            ->setTo($to)
            ->setSubject($subject)
            ->setTextBody($form)
            ->send();
    }

}