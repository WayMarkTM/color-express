<?php

/* @var $this yii\web\View */
use yii\web\View;

/* @var $selectedUserId integer */
?>

<div class="documents-container" ng-app="documents" ng-controller="clientDocumentsCtrl as $ctrl">
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
                         ng-class="{'active': year == $ctrl.selectedYear}"
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
</div>


<?php
    $position = View::POS_BEGIN;
    $this->registerJsFile('@web/js/angular.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJs('var selectedUserId = '.$selectedUserId.';', $position);
    $this->registerJsFile('@web/js/app/documents.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
