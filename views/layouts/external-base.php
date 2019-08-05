<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\components\StockWidget;

// AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(53320012, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/53320012" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel=”canonical” href=”http://colorexpo.by/” />
    <script type="text/javascript">
        var BASE_URL = '<?php echo Url::home(true); ?>';
    </script>
    <?php $this->head() ?>
    <link rel="stylesheet" href="/styles/external.css" />
</head>
<body class="external">
<?php $this->beginBody() ?>
  <?php $this->beginContent('@app/views/layouts/_partial/_header.php'); ?>
  <?php $this->endContent(); ?>

  <main class="main-content">
    <?= $content ?>
  </main>

  <?php $this->beginContent('@app/views/layouts/_partial/_footer.php'); ?>
  <?php $this->endContent(); ?>
<?php $this->endBody() ?>
<?php

StockWidget::begin();

StockWidget::end();
?>
</body>
</html>
<?php $this->endPage() ?>
