<?php
    /* @var $this yii\web\View */
    /* @var $portfolioItems array app\models\entities\PortfolioItem */

if ($this->title == null || $this->title == '') {
    $this->title = "Портфолио";
}
?>
<div class="row">
    <div class="col-sm-12 text-center">
        <h2 class="text-uppercase">Портфолио</h2>
    </div>
</div>

<div class="row">
<?php
    $i=0;
    foreach($portfolioItems as $portfolioItem)
    { ?>
        <div class="col-sm-2">
            <div class="client-container">
                <div class="client-logo">
                    <img src="/<?php echo $portfolioItem->image_url; ?>" />
                </div>
                <div class="client-name text-uppercase">
                    <?php echo $portfolioItem->title; ?>
                </div>
            </div>
        </div>
    <?php
        $i++;
        if ($i%6 == 0) echo '</div><div class="row">';
    }
?>
</div>