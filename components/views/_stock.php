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
        <div>
            <a href="#close" title="Закрыть" class="close" onclick="$('.stock-window').hide();">X</a>

            <?php echo $model->content; ?>
        </div>
    </div>

<?php } ?>

