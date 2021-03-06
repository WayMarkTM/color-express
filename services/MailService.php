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
use yii\helpers\Html;
use yii\helpers\Url;

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
        $text = '<p style="margin:auto;">Регистрация на сайте <a target="_blank" href="'.Url::home(true).'">'.Url::home(true).'</a> завершена. Спасибо!</p>';
        $subject = 'Вы зарегестрированы.';

        return $mail->send($user->username, $subject, $text);
    }

    public function resetPassword($user, $newPassword)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Служба восстановления пароля. Ваш текущий пароль для сайта <a target="_blank" href="'.Url::home(true).'">'.Url::home(true).'</a>: '.$newPassword.'. В целях безопасности советуем Вам сменить пароль в личном кабинете пользователя.<br></p>';
        $subject = 'Сброс пароля';

        return $mail->send($user->username, $subject, $text);
    }

    /* @param $reservation AdvertisingConstructionReservation */
    public function approveOrDeclineOrder($user, $reservation, $prev_status_id, $isApprove = true)
    {
        $mail = new Mail();
        if($prev_status_id == AdvertisingConstructionStatuses::IN_PROCESSING) {
            $mail_data = [
                'subject_approve' => 'Подтверждение оформленного заказа',
                'subject_decline' => 'Отклонение оформленного заказа',
                'body_approve' => 'Ваш заказ подтвержден. Наш менеджер с Вами свяжется.',
                'body_decline' => 'К сожалению, заказ отменен. Свяжитесь с Вашим менеджером.',
                'date' => 'Даты бронирования:',
            ];
        } else {
            $mail_data = [
                'subject_approve' => 'Подтверждение отложенного заказа',
                'subject_decline' => 'Отклонение отложенного заказа',
                'body_approve' => 'Ваш заказ отложен на 5 рабочих дней.',
                'body_decline' => 'К сожалению, заказ отменен. Свяжитесь с Вашим менеджером.',
                'date' => 'Даты резервации:',
                'additional' => 'Срок действи отложенного заказа: до '. $reservation->reserv_till,
            ];
        }
        if ($isApprove) {
            $orderIs = $mail_data['body_approve'];
            $subject = $mail_data['subject_approve'];
            $additional_info = $mail_data['additional'];
        } else {
            $orderIs = $mail_data['body_decline'];
            $subject = $mail_data['subject_decline'];
        }
        $text = '<p style="margin:auto;">'.$orderIs.'<br>'.$mail_data['date'].' '.$reservation->from.' - '.$reservation->to.'.<br>По адресу: '.$reservation->advertisingConstruction->address.isset($additional_info) && !empty($additional_info) ? '<br>'.$additional_info : ''.'</p>';

        return $mail->send($user->username, $subject, $text);
    }

    /** @param $reservation AdvertisingConstructionReservation */
    public function notificationForTheDayOfEndReservation($user, $reservation, $managerEmail)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Истекает срок отложенного заказа на сайте. Перейдите в личный кабинет для оформления заказа.<br/>Период размещения: '.$reservation->from.' - '.$reservation->to.'<br>По адресу: '.$reservation->advertisingConstruction->address.'</p>';
        $subject = 'Истчение срока отложенного заказа.';

        return $mail->send($user->username, $subject, $text, null, $managerEmail);
    }

    /** @param $reservation AdvertisingConstructionReservation */
    public function employeeRegisterForCompany($user, $reservation)
    {
        $mail = new Mail();
        $text = '<p style="margin:auto;">Заказ оформлен Вашим менеджером.<br/>Период размещения: '.$reservation->from.' - '.$reservation->to.'<br>По адресу: '.$reservation->advertisingConstruction->address.'</p>';
        $subject = 'Подтверждение заказа';

        return $mail->send($user->username, $subject, $text);
    }

    public function sendNotificateAboutFreeConstruction($sendTo, $constructionId, $managerEmail) {
        $mail = new Mail();
        $url = Url::to(['construction/details', 'id' => $constructionId], true);
        $text = '<p style="margin:auto;">Добрый день! Понравившаяся Вам конструкция доступна к покупке. <a target="_blank" href="'.$url.'">'.$url.'</a>.</p>';
        $subject = 'Освобождение конструкции.';

        return $mail->send($sendTo, $subject, $text, null, $managerEmail);
    }

}