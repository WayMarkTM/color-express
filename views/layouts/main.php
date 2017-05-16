<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Nav;

?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <div class="page-container">
        <div class="page-content">
            <?= $content ?>
            <div class="watermark">
                Сайт носит рекламно-информационный характер и не используется в качестве интернет-магазина, в том числе для торговли по образцам и с помощью курьера.
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>