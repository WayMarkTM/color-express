<?php
/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 14.05.2017
 * Time: 17:22
 */
/* @param $manager \app\models\User */
?>
<div class="manager-container">
    <?php if($manager): ?>
        <div class="block-row"><span>Ваш менеджер:</span></div>
        <div class="block-row"><span><?= $manager->name?></span></div>
        <div class="block-row"><img src="<?= $manager->photo ?>"></div>
        <div class="block-row"><span><?= $manager->username ?></span></div>
        <div class="block-row"><span><?= $manager->number ?></span></div>
    <?php else: ?>
        <span>Менеджер ещё не назначен</span>
    <?php endif; ?>
</div>
