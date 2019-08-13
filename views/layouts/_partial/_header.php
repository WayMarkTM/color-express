<?php
use app\models\constants\SiteSettingKey;
use app\models\entities\SiteSettings;
use app\components\NavbarWidget;

$this->registerCssFile(Yii::$app->request->baseUrl.'/styles/partial/header.css', ['depends' => ['app\assets\ExternalAsset']]);
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark my-0">
        <a class="navbar-brand" href="/">
            <div class="navbar-logo">
                <img class="img-fluid" src="/images/external/logo.png" alt="">
            </div>
        </a>
        <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-link-size" id="navbarTogglerDemo01">
            <?php 
                NavbarWidget::begin();
                NavbarWidget::end();
            ?>
            <div class="navbar-info">
                <a href="tel:<?php echo SiteSettings::findOne(SiteSettingKey::HEADER_PHONE)->value; ?>" class="number"><?php echo SiteSettings::findOne(SiteSettingKey::HEADER_PHONE)->value; ?></a>
                <div class="red-block">
                    premium outdoor
                </div>
            </div>
        </div>
    </nav>
</header>