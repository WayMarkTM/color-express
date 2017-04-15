<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 10.04.2017
 * Time: 18:06
 */
use yii\widgets\Menu;

/* @var $items array|mixed */

?>

<div class="menu-container">
    <?php
    echo Menu::widget([
        'items' => $items
    ]);
    ?>
</div>
