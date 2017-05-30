(function (selectedUserId, documentCalendar, subclients) {
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
        vm.selectSubclient = selectSubclient;
        vm.isMonthAvailable = isMonthAvailable;
        vm.isYearAvailable = isYearAvailable;
        vm.getDocumentLink = getDocumentLink;
        vm.openAddDocumentModal = openAddDocumentModal;
        vm.openAddSubclientModal = openAddSubclientModal;
        vm.deleteDocument = deleteDocument;


        function init() {
            vm.isDocumentsLoading = false;

            if (!!subclients && subclients.length > 0) {
                initSubclients();
                $scope.$watch(function () { return vm.selectedSubclientId; }, onSelectedSubclientChanged)
            } else {
                initCalendar(documentCalendar);
            }

            $scope.$watch(function () { return vm.selectedYear; }, onSelectedYearChanged);
            $scope.$watch(function () { return vm.selectedMonthId; }, onSelectedMonthChanged);

        }

        function initSubclients() {
            vm.subclients = subclients;
        }

        function onSelectedSubclientChanged(newVal, oldVal) {
            if (newVal != oldVal) {
                vm.calendar = null;
                vm.selectedYear = null;
            }
        }

        function selectSubclient(subclient) {
            vm.selectedSubclientId = subclient.id;

            documentDataService.loadSubclientCalendar(subclient.id)
                .then(initCalendar);
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
                documentDataService.loadDocuments(vm.selectedYear, vm.selectedMonthId, vm.selectedSubclientId)
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

        function deleteDocument($index, document) {
            if (confirm('Вы уверены, что хотите удалить документ ' + document.filename)) {
                documentDataService.deleteDocument(document.id)
                    .then(function () {
                        vm.documents.splice($index, 1);
                        toastr.success('Документ успешно удален');
                    });
            }
        }

        function openAddDocumentModal($event) {
            if (!!vm.selectedSubclientId) {
                $('#adddocumentform-subclientid').val(vm.selectedSubclientId);
            }

            if (!!selectedUserId) {
                $('#adddocumentform-userid').val(selectedUserId);
            }

            $('#add-document').modal('show');
        }

        function openAddSubclientModal($event) {
            if (!!selectedUserId) {
                $('#addsubclientform-userid').val(selectedUserId);
            }

            $('#add-subclient').modal('show');
        }
    }

    documentModule.service('documentDataService', documentDataService);

    documentDataService.$inject = ['$http'];

    function documentDataService($http) {
        return {
            loadCalendar: loadCalendar,
            loadDocuments: loadDocuments,
            loadSubclientCalendar: loadSubclientCalendar,
            deleteDocument: deleteDocument
        };

        function loadCalendar() {
            return $http.get(GATEWAY_URLS.GET_DOCUMENTS_CALENDAR + '?userId=' + selectedUserId)
                .then(function (response) {
                    return response.data.calendar;
                });
        }

        function loadDocuments(year, month, subclientId) {
            var url = GATEWAY_URLS.GET_DOCUMENTS + '?userId=' + selectedUserId + '&year=' + year + '&month=' + month;

            if (!!subclientId) {
                url += '&subclientId=' + subclientId;
            }

            return $http.get(url)
                .then(function (response) {
                    return response.data.documents;
                });
        }

        function loadSubclientCalendar(subclientId) {
            var url = GATEWAY_URLS.GET_SUBCLIENT_DOCUMENTS_CALENDAR + '?userId=' + selectedUserId + '&subclientId=' + subclientId;

            return $http.get(url)
                .then(function (response) {
                    return response.data.calendar;
                });
        }

        function deleteDocument(documentId) {
            var url = GATEWAY_URLS.DELETE_DOCUMENT + '?documentId=' + documentId;

            return $http.get(url);
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
})(selectedUserId, documentCalendar, subclients);
