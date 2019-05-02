<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 13.02.2017
 * Time: 18:38
 */

    /* @var $this yii\web\View */
    /* @var $clients array app\models\entities\OurClient */
if ($this->title == null || $this->title == '') {
    $this->title = "Наши Клиенты";
}
?>
<div class="row">
    <div class="col-sm-12 text-center">
        <h2 class="text-uppercase">Наши клиенты</h2>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <h4 class="text-uppercase">Занимаясь этим бизнесом более 25 лет</h4>
        <h4 class="text-uppercase">компании ООО «КОЛОРЭКСПРЕСС» доверили свои бренды такие компании как:</h4>
    </div>
</div>
<hr/>
<div class="row">
<?php
    $i=0;
    foreach($clients as $client)
    { ?>
        <div class="col-sm-2">
            <div class="client-container">
                <div class="client-logo">
                    <img src="<?php echo $client->logo_url; ?>" />
                </div>
                <div class="client-name text-uppercase">
                    <?php echo $client->name; ?>
                </div>
            </div>
        </div>
    <?php
        $i++;
        if ($i%6 == 0) echo '</div><div class="row">';
    }
?>
</div>

<hr/>
<div class="row">
    <div class="col-sm-12 text-center">
        <h4>Ваше мнение для нас важно.</h4>
        <p>Делитесь своими отзывами о нашей работе: обо всем, что кажется Вам важным.</p>
        <p>Это поможет нам совершенствоваться и улучшать качество наших услуг!</p>
    </div>
</div>