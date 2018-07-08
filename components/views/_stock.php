<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 28.04.2017
 * Time: 18:07
 */


/* @var $model \app\models\StockSettings */

if ($model->content) {
?>

    <div class="stock-window">
        <div class="content">
            <a href="#close" title="Закрыть" class="close" onclick="$('.stock-window').hide();">X</a>

            <img src="/<?= $model->content; ?>">
        </div>
        <div class="watermark">
            Сайт носит рекламно-информационный характер и не используется в качестве интернет-магазина, в том числе для торговли по образцам и с помощью курьера.
        </div>
    </div>

<?php } ?>

