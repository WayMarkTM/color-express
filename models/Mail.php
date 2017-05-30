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
    static $from = 'color.express.adm@gmail.com';

    public function send($to, $subject, $form, $file = null) {

        try {
            $message = \Yii::$app->mailer->compose()
                ->setFrom(Mail::$from)
                ->setTo($to)
                ->setSubject($subject)
                ->setHtmlBody($form);
            if (!empty($file)) {
                $message->attach($file);
            }
            return $message->send();
        } catch(\Exception $ex) {}
    }

}