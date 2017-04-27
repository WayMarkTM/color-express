<?php
/**
 * Created by PhpStorm.
 * User: gromi
 * Date: 4/17/2017
 * Time: 8:31 PM
 */

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $documentsCalendar array|mixed */
/* @var $subclients array|Subclient */

$this->title = $user->company;
?>

<ul class="nav nav-tabs" id="control-tabs">
    <li role="presentation"><a href="<?php echo Url::toRoute('clients/details?clientId='.$user->id); ?>">Заказы</a></li>
    <li role="presentation" class="active"><a href="#documents-tab">Документы</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel" id="documents-tab">
        <?= $this->render('_documents', [
            'isAgency' => $user->is_agency,
            'selectedUserId' => $user->id,
            'documentsCalendar' => $documentsCalendar,
            'subclients' => $subclients,
            'isViewMode' => false
        ]) ?>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="important-content text-uppercase"><?php echo $user->company; ?></h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="#" class="additional-link"><i class="icon edit-icon"></i>Редактировать данные</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon phone-icon"></i><?php echo $user->name ?></h4>
                    <div class="info-block-content internal">
                        <p><?php echo $user->number; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon email-icon"></i>Email:</h4>
                    <div class="info-block-content internal">
                        <p><?php echo $user->username; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon address-icon"></i>Адрес:</h4>
                    <div class="info-block-content internal">
                        <p><?php echo $user->address; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block-row">
            <div class="col-sm-12">
                <div class="info-block">
                    <h4 class="info-block-header internal"><i class="icon info-icon"></i>Информация:</h4>
                    <div class="info-block-content internal">
                        <p><?php echo $user->getType(); ?></p>
                        <p>Договор №384 от 20.08.2014 г.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>