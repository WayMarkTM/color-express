<?php

/* @var $this yii\web\View */
use app\models\entities\ExclusiveOfferPage;

$offer = ExclusiveOfferPage::find(1)->one();

?>

<meta property="og:title" content="<?php echo $offer->facebook_title; ?>">
<meta property="og:image" content="<?php echo $offer->image_path; ?>">

<div class="row exclusive-offer-body">
  <div class="col-sm-12 col-md-5 col-lg-5">
    <h1 class="font-weight-normal text-uppercase mb-4"><?php echo $offer->title; ?></h1>
    <?php echo $offer->formatted_text; ?>
    <p class="text-right">
      Поделиться
      <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcolorexpo.by%2Foffers&t=%D0%9F%D1%80%D0%BE%D0%B3%D1%80%D0%B0%D0%BC%D0%BC%D0%B0%20%D0%9B%D0%BE%D1%8F%D0%BB%D1%8C%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20%22%D0%A3%D0%B4%D0%B0%D1%87%D0%BD%D0%BE%D0%B5%20%D1%80%D0%B0%D0%B7%D0%BC%D0%B5%D1%89%D0%B5%D0%BD%D0%B8%D0%B5%22"
        onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
        target="_blank" title="Поделиться на Facebook">
        <img class="img-icon" src="/images/external/facebook.png" alt="">
      </a>
    </p>
  </div>
  <div class="col-sm-12 offset-md-1 offset-lg-1 col-md-6 col-lg-6">
    <img src="<?php echo $offer->image_path; ?>" class="w-100 mw-100" />
  </div>
</div>
