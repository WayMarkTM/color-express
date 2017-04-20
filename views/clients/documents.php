<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/16/2017
 * Time: 12:58 AM
 */
use app\models\entities\Subclient;

/* @var $this yii\web\View */
/* @var $currentUser \app\models\User */
/* @var $documentsCalendar array|mixed */
/* @var $subclients array|Subclient */

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
            'selectedUserId' => $currentUser->id,
            'isAgency' => $currentUser->is_agency,
            'documentsCalendar' => $documentsCalendar,
            'subclients' => $subclients,
            'isViewMode' => true
        ]) ?>
    </div>
</div>
