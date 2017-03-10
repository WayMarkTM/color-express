<?php

/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 13.02.2017
 * Time: 18:55
 */

/* @var $clients array app\models\entities\OurClient */

?>

<div class="row">
    <div class="col-md-6">
        <?php
            $i = 0;
            foreach($vacancies as $vacancy) { ?>
                <div class="row <?php echo $i == 0 ? '' : 'section-row'?>">
                    <div class="col-md-12">
                        <h4 class="text-uppercase bold"><?php echo $vacancy->title; ?></h4>
                        <hr/>
                        <p><?php echo $vacancy->content; ?></p>
                    </div>
                </div>
            <?php $i++; }
        ?>
    </div>
    <div class="col-md-offset-1 col-md-5">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-uppercase bold">Обратная связь</h4>
            </div>
        </div>
    </div>
</div>