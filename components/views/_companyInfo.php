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