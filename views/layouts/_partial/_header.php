<?php

$this->registerCssFile(Yii::$app->request->baseUrl.'/css/partial/header.css');

?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="/">
            <div class="navbar-logo">
                <img class="img-fluid" src="/web/images/icons/brand-icon.png" alt="">
            </div>
        </a>
        <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-link-size" id="navbarTogglerDemo01">
            <ul class="navbar-nav mx-auto ">
                <li class="nav-item active">
                    <a class="nav-link " href="#">купить онлайн <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="exclusive-offer.html">exclusive-offer</a>
                </li>
                <li class="nav-item">s
                    <a class="nav-link" href="about-company.html">о компании</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="portfolio.html">портфолио</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacts.html">контакты</a>
                </li>
            </ul>
            <span class="number">+375 29 306-70-22</span>
            <div class="red-block">
                <a href="#">primium outdoor</a>
            </div>
        </div>
    </nav>
</header>
