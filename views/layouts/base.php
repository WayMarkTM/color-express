<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Menu;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\AuthWidget;
use app\components\SignupWidget;
use app\models\User;

$menu = [
    ['label' => 'Каталог рекламных конструкций', 'url' => ['advertising-construction/index']],
    ['label' => 'Преимущества', 'url' => ['site/advantages']],
    ['label' => 'О компании', 'url' => ['site/about']],
    ['label' => 'Наши клиенты', 'url' => ['site/clients']],
    ['label' => 'Вакансии', 'url' => ['site/vacancies']],
    ['label' => 'Контакты', 'url' => ['site/contact']],
];

if(!Yii::$app->user->isGuest) {
    $user_id = Yii::$app->user->getId();
    $user = User::findIdentity($user_id);
    if($user->getRole() == 'admin') {
        $menu = [
            [
                'label' => 'Управление конструкциями',
                'url' => ['advertising-construction/index']
            ],
            [
                'label' => 'Управление размерами конструкций',
                'url' => ['advertising-construction-size/index']
            ],
            [
                'label' => 'Управление типами конструкций',
                'url' => ['advertising-construction-type/index']
            ],
            [
                'label' => 'Управление нашими клиентами',
                'url' => ['our-client/index']
            ],
//            [
//                'label' => 'Управление пользователями',
//                'url' => ['user/index']
//            ],
            [
                'label' => 'Управление вакансиями',
                'url' => ['vacancy/index']
            ]
        ];
    } else if($user->getRole() == 'client') {
        $menu = [
            [
                'label' => 'Оформить заказ',
                'url' => ['advertising-construction/index']
            ],
            [
                'label' => 'Корзина',
                'url' => ['shopping-cart/index']
            ],
            [
                'label' => 'Мои заказы',
                'url' => ['orders/index']
            ],
            [
                'label' => 'Документы',
                'url' => ['site/index']
            ]
        ];
    } else if($user->getRole() == 'employee') {
        $menu = [
            [
                'label' => 'Управление клиентами',
                'url' => ['clients/index']
            ],
            [
                'label' => 'Управление конструкциями',
                'url' => ['advertising-construction/index']
            ],
            [
                'label' => 'Новые заявки на регистрацию',
                'url' => ['registration-requests/index']
            ]
        ];
    }

}


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
                'items' => $menu
            ]);
            ?>
        </div>
        <div class="sign-buttons-container">
            <div class="contacts ">
                <div class="row block-row">
                    <span>outdoor@colorexpress.by</span>
                </div>
                <div class="row block-row">
                    <span>+375 (29) 777 22 33</span>
                </div>
                <div class="row block-row">
                    <span>+375 (29) 777 22 33</span>
                </div>
            </div>
            <? if(Yii::$app->user->isGuest): ?>
                <a href="#" class="pull-left" data-toggle="modal" data-target="#signup">Регистрация</a>
                <button class="custom-btn red pull-right" type="button" data-toggle="modal" data-target="#signin">Вход</button>

            <? else: ?>
                <a href="<?= Url::toRoute('site/logout')?>" class="custom-btn red pull-right" type="button">Выход</a>
            <? endif; ?>
        </div>
    </div>

    <div class="page-wrapper">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
<?php
if(Yii::$app->user->isGuest) {
    AuthWidget::begin();
    AuthWidget::end();
    SignupWidget::begin();
    SignupWidget::end();
}
?>
</body>
</html>
<?php $this->endPage() ?>
