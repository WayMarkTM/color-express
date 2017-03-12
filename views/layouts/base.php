<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="side-menu">
        <div class="logo-container">
            <div class="logo"></div>
        </div>
        <div class="menu-container">
            <?php
            echo Menu::widget([
                'items' => [
                    ['label' => 'Каталог рекламных конструкций', 'url' => ['advertising-construction/index']],
                    ['label' => 'Преимущества', 'url' => ['site/advantages']],
                    ['label' => 'О компании', 'url' => ['site/about']],
                    ['label' => 'Наши клиенты', 'url' => ['site/clients']],
                    ['label' => 'Вакансии', 'url' => ['site/vacancies']],
                    ['label' => 'Контакты', 'url' => ['site/contact']],
                ]
            ]);
            ?>
        </div>
        <div class="sign-buttons-container">
            <a href="#" class="pull-left">Регистрация</a>
            <button class="custom-btn red pull-right" type="button">Вход</button>
        </div>
    </div>

    <div class="page-wrapper">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
