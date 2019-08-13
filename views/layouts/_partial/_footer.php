<?php

use app\models\constants\SiteSettingKey;
use app\models\entities\SiteSettings;

$this->registerCssFile(Yii::$app->request->baseUrl.'/styles/partial/footer.css');

?>

<footer class="footer">
    <div class="container footer-container">
        <div class="row justify-content-between">
            <div class="col-sm-12 col-lg-3 footer-info mt-2">
                <a class="footer-main-logo" href="">
                    <img class="img-fluid" src="/images/external/logo.png" alt="">
                </a>
                <span class="footer-info-text">оператор наружной<br/>рекламы</span>
                <div class="social-links ml-4">
                    <a class="social-link" target="_blank" href="<?php echo SiteSettings::findOne(SiteSettingKey::FACEBOOK)->value; ?>"><img class="img-icon" src="/images/external/facebook.png" alt=""></a>
                    <a class="social-link" target="_blank" href="<?php echo SiteSettings::findOne(SiteSettingKey::INSTAGRAM)->value; ?>"><img class="img-icon" src="/images/external/insta.png" alt=""></a>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 footer-tel mt-2">
                <p class="footer-text font-weight-bold">
                    Телефоны:
                </p>
                <?php foreach (explode(";", SiteSettings::findOne(SiteSettingKey::FOOTER_PHONES)->value) as $phone) { ?>
                    <p class="my-0">
                        <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
                    </p>
                <?php } ?>
                <p class="mb-0 mt-3">E-mail:</P>
                <p class="my-0">
                    <a class="footer-link" href="mailto:<?php echo SiteSettings::findOne(SiteSettingKey::CONTACT_EMAIL)->value; ?>"><?php echo SiteSettings::findOne(SiteSettingKey::CONTACT_EMAIL)->value; ?></a>
                </p>
            </div>
            <div class="col-sm-12 col-lg-3 footer-menu mt-2">
                <p class="footer-text font-weight-bold">Информация:</p>
                <p class="my-0">
                    <a class="footer-link" href="/catalog">Купить online </a>
                </p>
                <p class="my-0">
                    <a class="footer-link" href="/offers">Exclusive offer</a>
                </p>
                <p class="my-0">
                    <a class="footer-link" href="/about">О компании </a>
                </p>
                <p class="my-0">
                    <a class="footer-link" href="/portfolio">Портфолио</a>
                </p>
                <p class="my-0">
                    <a class="footer-link" href="<?php echo SiteSettings::findOne(SiteSettingKey::PRESENTATION_LINK)->value; ?>">F.A.Q </a>
                </p>
                <p class="my-0">
                    <a class="footer-link" href="/contacts">Контакты</a>
                </p>
            </div>
            <div class="col-sm-12 col-lg-2 address mt-2">
                <a class="footer-second-logo" href="/">
                    <img class="img-fluid" src="/images/external/logo-footer.png" alt="">
                </a>
                <p class="footer-company-name footer-text font-weight-bold">
                    ООО &laquo;Колорэкспресс&raquo;
                </p>
                <p class="my-0">г. Минск,</p>
                <p class="my-0">ул. Железнодорожная,</p>
                <p class="my-0">дом 44, пом. 263</p>
            </div>
        </div>
    </div>
</footer>