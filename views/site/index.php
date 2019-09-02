<?php

/* @var $this yii\web\View */
use app\models\entities\Section;
use app\models\entities\CarouselImage;
use app\models\constants\SectionType;

$sections = Section::find()->orderBy('order ASC')->all();
$carouselImages = CarouselImage::find()->orderBy('order ASC')->all()

?>
<link rel="stylesheet" href="/styles/landing.css" />
<div class="landing">
    <div class="carousel-block">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php for ($i = 0; $i < count($carouselImages); $i++) { ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>"></li>
            <?php } ?>
        </ol>
        <div class="carousel-inner">
            <?php for ($i = 0; $i < count($carouselImages); $i++) { ?>
                <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                    <img class="d-block w-100" src="<?php echo $carouselImages[$i]->path; ?>">
                </div>
            <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    </div>
    <?php foreach ($sections as $section) { ?>
        <div class="section-header">
            <h3>
                <?php echo $section->title; ?>
            </h3>
        </div>
        <div class="container my-5">
        <?php switch ($section->type_id) {
            case SectionType::FREE_TEXT:
                $sectionDetails = $section->getSectionDetails()->orderBy('order ASC')->all();
                foreach ($sectionDetails as $sectionDetail) { ?>
                    <div class="row info-block-pos">
                        <?php echo $sectionDetail->formatted_text; ?>
                    </div>
                <?php }
                break;
            case SectionType::FREE_TEXT_WITH_IMAGE:
                $sectionDetails = $section->getSectionDetails()->orderBy('order ASC')->all();
                foreach ($sectionDetails as $sectionDetail) { ?>
                    <div class="row info-block-pos">
                        <div class="col">
                            <?php echo $sectionDetail->formatted_text; ?>
                        </div>
                        <div class="col">
                            <img class="w-100" src="<?php echo $sectionDetail->image_path; ?>" />
                        </div>
                    </div>
                <?php }
                break;
            case SectionType::CIRCLES: ?>
                <div class="row">
                <?php
                    $sectionDetails = $section->getSectionDetails()->orderBy('order ASC')->all();
                    foreach ($sectionDetails as $sectionDetail) {
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-12 service"><img src="<?php echo $sectionDetail->image_path; ?>" alt="">
                        <p class="service-text"><?php echo $sectionDetail->formatted_text; ?></p>
                    </div>
                <?php } ?>
                </div>
            <?php break;
            case SectionType::TILE_2: ?>
                <div class="row">
                <?php
                    $sectionDetails = $section->getSectionDetails()->orderBy('order ASC')->all();
                    foreach ($sectionDetails as $sectionDetail) {
                ?>
                    <div class="col-lg-6 col-sm-12 card-opportunity">
                        <a href="<?php echo $sectionDetail->link_to; ?>">
                            <div class="card">
                                <img class="card-img" src="<?php echo $sectionDetail->image_path; ?>" alt="Card images/external">
                                <div class="card-img-overlay card-desc">
                                    <p class="card-text my-0"><?php echo $sectionDetail->formatted_text; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                </div>
            <?php break;
            case SectionType::TILE_3: ?>
                <div class="row">
                <?php
                    $sectionDetails = $section->getSectionDetails()->orderBy('order ASC')->all();
                    foreach ($sectionDetails as $sectionDetail) {
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 card-example">
                        <div class="card">
                            <img class="card-img" src="<?php echo $sectionDetail->image_path; ?>" alt="Card images/external">
                            <div class="card-img-overlay card-desc">
                                <p class="card-text my-0"><?php echo $sectionDetail->formatted_text; ?></p>
                                <a class="card-link" target="_blank" href="<?php echo $sectionDetail->link_to; ?>">
                                    <?php echo $sectionDetail->link_text; ?>
                                    <img class="img-icon" src="<?php echo $sectionDetail->link_icon; ?>" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            <?php break;
            default:
                echo 'empty';
        } ?>
        </div>
    <?php } ?>
</div>

<script>
    $('.carousel').carousel({
        interval: 4000
    });
</script>