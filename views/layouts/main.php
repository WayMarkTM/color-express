<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Nav;

?>
<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <div class="page-container">
        <div class="page-content">
            <?= $content ?>
        </div>
    </div>
<?php $this->endContent(); ?>