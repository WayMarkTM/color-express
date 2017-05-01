<?php

/* @var $this yii\web\View */
use app\components\AddDocumentWidget;
use app\components\AddSubclientWidget;
use app\services\JsonService;
use yii\web\View;

/* @var $isAgency bool */
/* @var $selectedUserId integer */
/* @var $documentsCalendar array */
/* @var $subclients array|Subclient */
/* @var $isViewMode bool */
?>

<div class="documents-container" ng-app="documents" ng-controller="clientDocumentsCtrl as $ctrl">
    <div class="row">
        <?php if ($isAgency) { ?>
            <div class="col-sm-4">
                <?php if (count($subclients) > 0) { ?>
                    <table class="documents-table table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px">Детализированная задолженность</th>
                                <th class="text-center">№</th>
                                <th class="text-center">Сюжет</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="subclient in $ctrl.subclients"
                                ng-class="{'active': subclient.id == $ctrl.selectedSubclientId}"
                                ng-click="$ctrl.selectSubclient(subclient)">
                                <td>
                                    {{ subclient.arrear }}
                                </td>
                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    {{ subclient.name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php } else { ?>
                    Нет субклиентов.
                <?php } ?>
            </div>
        <?php } ?>
        <div class="col-sm-<?php echo $isAgency ? 8 : 12; ?>">
             <table class="documents-table table table-bordered" ng-if="!!$ctrl.calendar">
                <thead>
                    <tr>
                        <th>Год</th>
                        <th>Месяц</th>
                        <th>Документы</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="years">
                            <div class="item-year"
                                 ng-repeat="year in $ctrl.years"
                                 ng-class="{'active': year == $ctrl.selectedYear, 'not-available': !$ctrl.isYearAvailable(year)}"
                                 ng-click="$ctrl.selectYear(year)">
                                {{year}}
                            </div>
                        </td>
                        <td id="months">
                            <div class="item-month"
                                 ng-class="{'active': month.id == $ctrl.selectedMonthId, 'not-available': !$ctrl.isMonthAvailable(month)}"
                                 ng-click="$ctrl.selectMonth(month)"
                                 ng-repeat="month in $ctrl.months">
                                {{ month.name }}
                            </div>
                        </td>
                        <td id="documents">
                            <div ng-if="!$ctrl.documents && !!$ctrl.selectedMonthId && !$ctrl.isDocumentsLoading">
                                Документов в заданном месяце не найдено
                            </div>
                            <div ng-if="$ctrl.isDocumentsLoading">
                                Список документов загружается. Пожалуйста, подождите...
                            </div>
                            <div class="item-document"
                                 ng-if="$ctrl.documents.length > 0 && !$ctrl.isDocumentsLoading"
                                 ng-repeat="document in $ctrl.documents">
                                <a href="{{$ctrl.getDocumentLink(document)}}">{{ document.path }}</a>
                                <?php if (!$isViewMode) { ?>
                                    <a href="" ng-click="$ctrl.deleteDocument($index, document)">X</a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p ng-if="!$ctrl.calendar">Нет документов.</p>
        </div>
    </div>

    <div class="row">
        <?php if (!$isViewMode) { ?>
            <?php if ($isAgency) { ?>
                <div class="col-sm-4">
                    <a href="#" class="additional-link" ng-click="$ctrl.openAddSubclientModal($event)"><i class="icon add-subclient-icon"></i>Добавить субклиента</a>
                </div>
            <?php } ?>
            <div class="col-sm-8" ng-if="!!$ctrl.selectedSubclientId || !$ctrl.subclients || $ctrl.subclients.length == 0">
                <a href="#" class="additional-link" ng-click="$ctrl.openAddDocumentModal($event)"><i class="icon add-document-icon"></i>Добавить документ</a>
            </div>
        <?php } ?>
    </div>
</div>

<?php
    AddDocumentWidget::begin();
    AddDocumentWidget::end();
    AddSubclientWidget::begin();
    AddSubclientWidget::end();
?>

<?php
$modelAttributeNames = 'id, name';
?>

<?php
    $position = View::POS_BEGIN;
    $this->registerJs('var selectedUserId = '.$selectedUserId.';', $position);
    $this->registerJs('var documentCalendar = '.json_encode($documentsCalendar).';', $position);
    $this->registerJs('var subclients = '. JsonService::json_encode_database_models($subclients, $modelAttributeNames).';', $position);
    $this->registerJsFile('@web/js/angular.min.js'); //, ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('@web/js/app/documents.js'); //, ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
