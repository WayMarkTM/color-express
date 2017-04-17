<?php

/* @var $this yii\web\View */
use yii\web\View;

/* @var $selectedUserId integer */
/* @var $documentsCalendar array */
?>

<div class="documents-container" ng-app="documents" ng-controller="clientDocumentsCtrl as $ctrl">
    <div class="row">
        <div class="col-sm-12">
            <?php if (count($documentsCalendar) > 0) { ?>
                <table class="documents-table table">
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
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php } else { ?>
            <p>Нет документов.</p>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <a href="#" class="additional-link" data-toggle="modal" data-target="#add-document"><i class="icon add-document-icon"></i>Добавить документ</a>
        </div>
    </div>
</div>


<?php
    $position = View::POS_BEGIN;
    $this->registerJs('var selectedUserId = '.$selectedUserId.';', $position);
    $this->registerJs('var documentCalendar = '.json_encode($documentsCalendar).';', $position);
    $this->registerJsFile('@web/js/angular.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('@web/js/app/documents.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
