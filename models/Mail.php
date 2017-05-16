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
    static $from = 'color_admin@gmail.com';

    public function send($to, $subject, $form, $file = null) {
        //\Yii::$app->mailer->compose('contact/html', ['contactForm' => $form])
        $message = \Yii::$app->mailer->compose()
            ->setFrom(Mail::$from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($form);
            if(!empty($file)) {
                $message->attach($file);
            }
        return $message->send();
    }

}