<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\components\AddDocumentWidget;
use app\components\CompanyInfoWidget;
use app\components\MenuWidget;
use app\components\AddSubclientWidget;
use app\components\StockWidget;
use app\components\BalanceWidget;
use app\models\User;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\components\AuthWidget;
use app\components\SignupWidget;
use app\components\ManagerWidget;
use app\components\WelcomeWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(53320012, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/53320012" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel=”canonical” href=”http://colorexpo.by/” />
    <script type="text/javascript">
        var BASE_URL = '<?php echo Url::home(true); ?>';
    </script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="side-menu">
        <div class="logo-container">
            <a href="/" class="logo"></a>
        </div>
        <?php
            if(!Yii::$app->user->isGuest) {
                echo WelcomeWidget::widget();
            }

            MenuWidget::begin();
            MenuWidget::end();

            if(Yii::$app->user->can('client') && !Yii::$app->user->can('admin')) {
                echo BalanceWidget::widget();
            }

        if(Yii::$app->user->can('client') && !Yii::$app->user->can('admin')) {
                echo ManagerWidget::widget();
            }
        ?>
        <div class="sign-buttons-container">
            <?php
                if(Yii::$app->user->isGuest) {
                    CompanyInfoWidget::begin();
                    CompanyInfoWidget::end();
                }
            ?>
            <? if(Yii::$app->user->isGuest): ?>
                <a href="#" class="pull-left" data-toggle="modal" data-target="#signup">Регистрация</a>
                <button class="custom-btn red pull-right" type="button" data-toggle="modal" data-target="#signin">Вход</button>

            <? else: ?>
                <a href="<?= Url::toRoute('/site/logout')?>" class="custom-btn" type="button">Выход</a>
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

StockWidget::begin();
StockWidget::end();
?>
</body>
</html>
<?php $this->endPage() ?>
