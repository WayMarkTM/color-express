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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script>
        try {
            var nVer = navigator.appVersion;
            var nAgt = navigator.userAgent;
            var browserName = navigator.appName;
            var fullVersion = '' + parseFloat(navigator.appVersion);
            var majorVersion = parseInt(navigator.appVersion, 10);
            var nameOffset, verOffset, ix;
            var message = "Версия Вашего браузера ниже требуемой. Для корректной работы сайта рекомендуется обновить версию браузера до актуальной.";

            if ((verOffset = nAgt.indexOf("MSIE")) != -1) {
                browserName = "Microsoft Internet Explorer";
                fullVersion = nAgt.substring(verOffset + 5);
            } else if ((verOffset = nAgt.indexOf("Chrome")) != -1) {
                browserName = "Chrome";
                fullVersion = nAgt.substring(verOffset + 7);
            } else if ((verOffset = nAgt.indexOf("Firefox")) != -1) {
                browserName = "Firefox";
                fullVersion = nAgt.substring(verOffset + 8);
            } else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) < (verOffset = nAgt.lastIndexOf('/'))) {
                browserName = nAgt.substring(nameOffset, verOffset);
                fullVersion = nAgt.substring(verOffset + 1);
                if (browserName.toLowerCase() == browserName.toUpperCase()) {
                    browserName = navigator.appName;
                }
            }

            if ((ix = fullVersion.indexOf(";")) != -1)
                fullVersion = fullVersion.substring(0, ix);

            if ((ix = fullVersion.indexOf(" ")) != -1)
                fullVersion = fullVersion.substring(0, ix);

            majorVersion = parseInt('' + fullVersion, 10);
            if (isNaN(majorVersion)) {
                fullVersion = '' + parseFloat(navigator.appVersion);
                majorVersion = parseInt(navigator.appVersion, 10);
            }

            //for IE
            if (document.all) {
                alert(message);
            }

            if (browserName == "Firefox" && majorVersion < 46) {
                alert(message);
            }
        } catch (e) {
            console.error(e);
        }
    </script>
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
            <div class="logo"></div>
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
