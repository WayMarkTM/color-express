(function (selectedUserId, documentCalendar) {
    "use strict";

    var documentModule = angular.module('documents', []);

    documentModule
        .controller('clientDocumentsCtrl', clientDocumentsCtrl);

    clientDocumentsCtrl.$inject = ['documentDataService', 'months', '$scope'];

    function clientDocumentsCtrl(documentDataService, months, $scope) {
        var vm = this;

        vm.$onInit = init;
        vm.selectYear = selectYear;
        vm.selectMonth = selectMonth;
        vm.isMonthAvailable = isMonthAvailable;
        vm.isYearAvailable = isYearAvailable;
        vm.getDocumentLink = getDocumentLink;

        function init() {
            vm.isDocumentsLoading = false;

            initCalendar(documentCalendar);

            $scope.$watch(function () { return vm.selectedYear; }, onSelectedYearChanged);
            $scope.$watch(function () { return vm.selectedMonthId; }, onSelectedMonthChanged);

        }

        function initCalendar(calendar) {
            vm.calendar = calendar;
            vm.years = _.keys(vm.calendar);
            vm.months = months;
        }

        function onSelectedYearChanged(newVal, oldVal) {
            if (newVal != oldVal) {
                vm.selectedMonthId = null;
                vm.documents = null;
            }
        }

        function onSelectedMonthChanged(newVal, oldVal) {
            if (newVal != oldVal && newVal != null) {
                vm.documents = null;
                vm.isDocumentsLoading = true;
                documentDataService.loadDocuments(vm.selectedYear, vm.selectedMonthId)
                    .then(onDocumentsLoaded)
                    .finally(function () {
                        vm.isDocumentsLoading = false;
                    });
            }
        }

        function selectYear(year) {
            if (!isYearAvailable(year)) {
                return;
            }

            vm.selectedYear = year;
        }

        function isMonthAvailable(month) {
            return !!vm.selectedYear && !!vm.calendar[vm.selectedYear][month.id];
        }

        function isYearAvailable(year) {
            return vm.calendar[year] != false;
        }

        function selectMonth(month) {
            if (!isMonthAvailable(month)) {
                return;
            }

            vm.selectedMonthId = month.id;
        }

        function onDocumentsLoaded(documents) {
            vm.documents = documents;
        }

        function getDocumentLink(document) {
            return '/uploads/documents/' + selectedUserId + '/' + vm.selectedYear + '/' + vm.selectedMonthId + '/' + document.path;
        }
    }

    documentModule.service('documentDataService', documentDataService);

    documentDataService.$inject = ['$http'];

    function documentDataService($http) {
        return {
            loadCalendar: loadCalendar,
            loadDocuments: loadDocuments
        };

        function loadCalendar() {
            return $http.get(GATEWAY_URLS.GET_DOCUMENTS_CALENDAR + '?userId=' + selectedUserId)
                .then(function (response) {
                    return response.data.calendar;
                });
        }

        function loadDocuments(year, month) {
            var url = GATEWAY_URLS.GET_DOCUMENTS + '?userId=' + selectedUserId + '&year=' + year + '&month=' + month;

            return $http.get(url)
                .then(function (response) {
                    return response.data.documents;
                });
        }
    }

    var MONTHS = [{
        id: 1,
        name: 'Январь'
    }, {
        id: 2,
        name: 'Февраль'
    }, {
        id: 3,
        name: 'Март'
    }, {
        id: 4,
        name: 'Апрель'
    }, {
        id: 5,
        name: 'Май'
    }, {
        id: 6,
        name: 'Июнь'
    }, {
        id: 7,
        name: 'Июль'
    }, {
        id: 8,
        name: 'Август'
    }, {
        id: 9,
        name: 'Сентябрь'
    }, {
        id: 10,
        name: 'Октябрь'
    }, {
        id: 11,
        name: 'Ноябрь'
    }, {
        id: 12,
        name: 'Декабрь'
    }];

    documentModule.constant('months', MONTHS);
})(selectedUserId, documentCalendar);
