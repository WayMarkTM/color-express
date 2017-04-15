<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/16/2017
 * Time: 12:58 AM
 */

/* @var $this yii\web\View */
/* @var $currentUser \app\models\User */

$this->title = 'Документы';
?>

<div class="row">
    <div class="col-md-12">
        <h3 class="text-uppercase">Документы</h3>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-uppercase"><?php echo $currentUser->company; ?></h3>
    </div>
</div>

<div class="row block-row">
    <div class="col-md-12">
        <?= $this->render('_documents', [
            'selectedUserId' => $currentUser->id
        ]) ?>
    </div>
</div>
