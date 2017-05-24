<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 17.05.2017
 * Time: 0:30
 */

namespace app\services;


use app\models\constants\AdvertisingConstructionStatuses;
use app\models\ContactForm;
use app\models\entities\AdvertisingConstructionReservation;
use app\models\Mail;
use app\models\FeedBackForm;
use app\models\User;

class MailService
{
    /* @param $feedbackForm FeedBackForm */
    public function sendFeedback($feedbackForm)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Имя: '.$feedbackForm->name.'<br>Телефон: '.$feedbackForm->phone.'<br>Email: '.$feedbackForm->email.'<br>Сообщение: '.$feedbackForm->message.'</p>';
        $subject = 'Отклик на вакансию от: '.$feedbackForm->email;


        return $mail->send(SiteSettingsService::getContactEmail(), $subject, $text, $feedbackForm->upload_resume);
    }

    /* @param $contactForm ContactForm */
    public function sendContactForm($contactForm)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Имя: '.$contactForm->name.'<br>Телефон: '.$contactForm->phone.'<br>Сообщение: '.$contactForm->body.'</p>';
        $subject = 'Контактная форма от: '.$contactForm->name;

        return $mail->send(SiteSettingsService::getContactEmail(), $subject, $text);
    }

    /* @param $user User */
    public function sendActiveUserAccount($user)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Ваш аккаунт активирован: '.$user->username.'<br>Ваш менеджер: '.$user->manage->name.'<br></p>';
        $subject = 'Ваш аккаунт активирован';

        return $mail->send($user->username, $subject, $text);
    }

    /* @param $user User */
    public function sendSignUpUser($user)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Ваш аккаунт зарегистрирован.<br>Мы вас уведомим, когда Ваш аакаунт будет активирован.<br></p>';
        $subject = 'Регитрация аакаунта';

        return $mail->send($user->username, $subject, $text);
    }

    public function resetPassword($user, $newPassword)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Ваш пароль был сброшен.<br>Теперь ваш пароль: '.$newPassword.'.<br></p>';
        $subject = 'Сброс пароля';

        return $mail->send($user->username, $subject, $text);
    }

    /* @param $reservation AdvertisingConstructionReservation */
    public function approveOrDeclineOrder($user, $reservation, $prev_status_id, $isApprove = true)
    {
        $mail = new Mail();
        if($prev_status_id == AdvertisingConstructionStatuses::IN_PROCESSING) {
            $mail_data = [
                'subject_approve' => 'Ваша бронь была подтверждена.',
                'subject_decline' => 'Ваша бронь была отклонена.',
                'date' => 'Даты бронирования:',
            ];
        } else {
            $mail_data = [
                'subject_approve' => 'Ваша резервация была подтверждена.',
                'subject_decline' => 'Ваша резервация была отклонена.',
                'date' => 'Даты резервации:',
            ];
        }
        if ($isApprove) {
            $orderIs = $mail_data['subject_approve'];
        } else {
            $orderIs = $mail_data['subject_decline'];
        }
        $text = '<p style="margin:auto;">'.$orderIs.'<br>'.$mail_data['date'].' '.$reservation->from.' - '.$reservation->to.'.<br>По адресу: '.$reservation->advertisingConstruction->address.'</p>';
        $subject = $orderIs;

        return $mail->send($user->username, $subject, $text);
    }

    public function notificationForTheDayOfEndReservation($user, $reservation)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Напоминаем Вам, что Ваша резервация по адресу '.$reservation->advertisingConstruction->address.' заканчивается.<br></p>';
        $subject = 'Окончание резервации';

        return $mail->send($user->username, $subject, $text);
    }

}