<?php
    /* @var $this yii\web\View */
    /* @var $portfolioItems array app\models\entities\PortfolioItem */

if ($this->title == null || $this->title == '') {
    $this->title = "Портфолио";
}

$this->registerJsFile('@web/fancybox/jquery.fancybox.min.js');
?>

<link rel="stylesheet" href="/fancybox/jquery.fancybox.min.css" type="text/css" media="screen" />

<div class="row">
    <div class="col-12">
        <h1 class="ml-5 text-uppercase font-weight-normal">Портфолио</h1>
    </div>
</div>
<div class="mt-3 row">
    <?php foreach($portfolioItems as $portfolioItem) { ?>
    <div class="col-sm-12 col-md-6 col-lg-3 px-0">
        <a
            data-fancybox="gallery"
            data-caption="<?php echo $portfolioItem->title; ?>"
            href="/<?php echo $portfolioItem->image_url; ?>"
        >
            <img class="mw-100" src="/<?php echo $portfolioItem->image_url; ?>" />
        </a>
    </div>
    <?php } ?>
</div>
