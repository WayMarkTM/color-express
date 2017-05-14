<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

if ($exception->statusCode >= 500 )
    $name = 'Ошибка сервера (#'.$exception->statusCode.')';
elseif ($exception->statusCode == 400)
    $name = 'Неверный запрос (#'.$exception->statusCode.')';
elseif ($exception->statusCode == 401)
    $name = 'Вы не авторизованы (#'.$exception->statusCode.')';
elseif ($exception->statusCode == 403)
    $name = 'Запрещено (#'.$exception->statusCode.')';
elseif ($exception->statusCode == 404)
    $name = 'Страница не найдена(#'.$exception->statusCode.')';
elseif ($exception->statusCode == 405)
    $name = 'Метод не поддерживается (#'.$exception->statusCode.')';
elseif ($exception->statusCode > 405 || $exception->statusCode == 402)
    $name = 'Ошибка (#'.$exception->statusCode.')';

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

</div>
