<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 28.04.2017
 * Time: 16:55
 */

/* @var $model \app\models\ContactSettings */

?>

<div class="contacts ">
    <div class="row block-row social-networks">
        <a href="<?php echo $model->instagram ?>" target="_blank">
            <img src="/images/instagram.png" />
        </a>
        <a href="<?php echo $model->facebook ?>" target="_blank">
            <img src="/images/facebook.png" />
        </a>
    </div>
    <div class="row block-row">
        <span>ООО "Колорэкспресс"</span>
    </div>
    <div class="row block-row">
        <span><?php echo $model->email; ?></span>
    </div>
    <?php foreach ($model->phones as $phone) { ?>
        <div class="row block-row">
            <span><?php echo $phone; ?></span>
        </div>
    <?php } ?>
</div>