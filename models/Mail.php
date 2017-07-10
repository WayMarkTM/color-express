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

    /**
     * @param string $to
     * @param string $subject
     * @param string $from
     * @param null $file
     * @param string|null $bcc
     * @return bool
     */
    public function send($to, $subject, $from, $file = null, $bcc = null) {

        try {
            $message = \Yii::$app->mailer->compose()
                ->setFrom(Mail::$from)
                ->setTo($to)
                ->setSubject($subject)
                ->setHtmlBody($from);

            if ($bcc != null) {
                $message->setBcc($bcc);
            }

            if (!empty($file)) {
                $message->attach($file);
            }
            return $message->send();
        } catch(\Exception $ex) {}
    }

}