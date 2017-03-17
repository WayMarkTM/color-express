<?php
/**
 * Created by PhpStorm.
 * User: e.chernyavsky
 * Date: 17.03.2017
 * Time: 12:37
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\widgets\Breadcrumbs;

?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= $content ?>
<?php $this->endContent(); ?>

