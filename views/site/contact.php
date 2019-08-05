<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
/* @var $contactSettings app\models\ContactSettings */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

if ($this->title == null || $this->title == '') {
    $this->title = "Контакты";
}
?>

<div class="row">
    <div class="col-sm-12">
        <h1 class="text-uppercase font-weight-normal mb-5">Контакты</h1>
    </div>
</div>


<div class="row">
    <div class="col-sm-7">
        <div class="row mb-4">
            <div class="col-sm-12">
                <p class="my-0 text-uppercase"><strong>ООО "Колорэкспресс"</strong></p>
                <p>
                    Департамент наружной рекламы
                </p>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-sm-12 col-md-6 col-lg-4 d-flex">
                <div class="pr-3 pt-1">
                    <img src="/images/external/telephone.png" />
                </div>
                <div>
                    <p class="my-0"><a href="tel:+375173991096" class="text-body">+375 (17) 399-10-96</a></p>
                    <p class="my-0"><a href="tel:+375173991097" class="text-body">+375 (17) 399-10-97</a></p>
                    <p class="my-0"><a href="tel:+375173991087" class="text-body">+375 (17) 399-10-87</a></p>
                    <p class="my-0"><a href="tel:+375173991095" class="text-body">+375 (17) 399-10-95</a></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 d-flex">
                <div class="pr-3 pt-1">
                    <img src="/images/external/mobile.png" />
                </div>
                <div>
                    <p class="my-0"><a href="tel:+375291992787" class="text-body">+375 (29) 199-27-87</a></p>
                    <p class="my-0"><a href="tel:+375296450443" class="text-body">+375 (29) 645-04-43</a></p>
                    <p class="my-0"><a href="tel:+375293067022" class="text-body">+375 (29) 306-70-22</a></p>
                    <p class="my-0"><a href="tel:+375447425921" class="text-body">+375 (44) 742-59-21</a></p>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-sm-12 d-flex">
                <div class="pr-3 pl-1">
                    <img src="/images/external/message.png" />
                </div>
                <div class="pt-1">
                    Email: outdoor@colorexpress.by
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-sm-12 d-flex">
                <div class="pr-3">
                    <img src="/images/external/location.png" />
                </div>
                <div>
                    <p class="my-0">Наш адрес:</p>
                    <p>г. Минск, ул. Железнодорожная, 44</p>
                </div>
            </div>
        </div>
        <hr />
        <div class="row mt-4">
            <div class="col-sm-12 col-md-4">
                <img src="/images/external/logo-contact.png" class="mw-100" />
                <p class="mt-3">
                    ООО "Колорэкспресс" - мультибрендовая компания с 25-ти летней историей, имеющая в своем портфеле три бренда
                </p>
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="row">
                    <div class="col-4">
                        <a href="http://leader-outdoor.by">
                            <img src="/images/external/leader-logo.png" />
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="https://krasavik.by">
                            <img src="/images/external/krasavik-logo.png" />
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="http://colorexpo.by/">
                            <img src="/images/external/brand-colorexpo.png" />
                        </a>
                    </div>
                </div>
                <hr />
                <p class="my-0 text-danger font-weight-bold">www.leaderoutdoor.by</p>
                <p class="text-uppercase text-secondary">Имиджевые надкрышные рекламные конструкции</p>
                <p>
                    Большие световые короба и объемные буквы с подсветкой обеспечивают положительное эмоциональное и эстетическое воздействие на самую широкую аудиторию. Ваш бренд на крышной установке становится не просто рекламой, а частью городского пейзажа.
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <script type="text/javascript">
            ymaps.ready(init);

            function init () {
                var map = new ymaps.Map('map', {
                        center: [<?php echo $contactSettings->latitude; ?>, <?php echo $contactSettings->longitude; ?>],
                        zoom: 16
                    }, {
                        searchControlProvider: 'yandex#search'
                    }),
                    myGeoObject = new ymaps.GeoObject({
                        geometry: {
                            type: "Point",
                            coordinates: [<?php echo $contactSettings->latitude; ?>, <?php echo $contactSettings->longitude; ?>]
                        },
                        properties: {
                            balloonContent: 'Железнодорожная улица, 44'
                        }
                    }, {
                        preset:'islands#icon',
                        iconColor: '#a5260a'
                    });

                map.geoObjects.add(myGeoObject);
            }
        </script>
        <div id="map" style="height: 500px; width: 100%"></div>
    </div>
</div>