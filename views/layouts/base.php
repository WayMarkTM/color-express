<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\components\AddDocumentWidget;
use app\components\MenuWidget;
use app\components\AddSubclientWidget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\components\AuthWidget;
use app\components\SignupWidget;

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
            MenuWidget::begin();
            MenuWidget::end();
        ?>
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
                <a href="<?= Url::toRoute('site/logout')?>" class="custom-btn" type="button">Выход</a>
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
