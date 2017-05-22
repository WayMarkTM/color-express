(function (constructions, constructionTypes, selectedConstructionType, isGuest, isEmployee) {
    "use strict";

    var constructionsModule = angular
        .module('constructions', ['yaMap', 'ui.bootstrap']);

    constructionsModule
        .config(appconfig);

    appconfig.$inject = ['$httpProvider'];

    function appconfig($httpProvider){
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr('content');
    }

    constructionsModule
        .filter('startFrom', function() {
            return function(input, start) {
                start = +start;
                return input.slice(start);
            }
        });


    constructionsModule
        .controller('constructionsCtrl', constructionsCtrl);

    constructionsCtrl.$inject = ['$window', 'constructionsDataService', '$scope', '$uibModal'];

    function constructionsCtrl($window, constructionsDataService, $scope, $uibModal) {
        var vm = this;

        vm.$onInit = init;
        vm.showSummary = showSummary;
        vm.buyConstructions = buyConstructions;
        vm.reservConstructions = reservConstructions;
        vm.showSummary = showSummary;
        vm.selectConstructionType = selectConstructionType;
        vm.selectConstruction = selectConstruction;
        vm.getPriceForMonth = getPriceForMonth;
        vm.showRequireAuthorizationModal = showRequireAuthorizationModal;
        vm.getSelectedConstructions = getSelectedConstructions;
        vm.getReport = getReport;

        function init() {
            vm.isEmployee = isEmployee;
            vm.isGuest = isGuest;
            vm.constructions = constructions;
            vm.constructionTypes = [];
            vm.currentPage = 1;
            vm.ITEMS_PER_PAGE = 7;
            vm.queryString = window.location.href.slice(window.location.href.indexOf('?') + 1);
            vm.selectedConstructionType = selectedConstructionType;
            _.forEach(constructionTypes, function (type, key) {
                vm.constructionTypes.push({
                    id: key,
                    name: type
                });
            });

            _.forEach(vm.constructions, function (construction) {
                construction.yaPoint = {
                    geometry: {
                        type: "Point",
                        coordinates: [construction.long, construction.lat]
                    },
                    properties: {
                        balloonContentHeader: construction.name,
                        balloonContent: (!!construction.previewImage ?
                            '<img class="info-window-image-preview" src="/' + construction.previewImage + '"/>'
                            : '')
                    }
                };
            });

            $scope.$watch(function () { return vm.getSelectedConstructions(); }, onSelectedConstructionChanged, true);
        }

        function onSelectedConstructionChanged() {
            constructionsDataService.setSelectedConstructions(vm.getSelectedConstructions());
        }

        function getPriceForMonth(construction) {
            return (construction.price * 30).toFixed(2);
        }

        function selectConstruction(construction) {
            vm.selectedConstruction = construction;

            var index = _.findIndex(vm.constructions, { 'id': construction.id });
            vm.currentPage = Math.ceil((index + 1)/vm.ITEMS_PER_PAGE);
        }

        function selectConstructionType(id) {
            vm.selectedConstructionType = id;
            $('#advertisingconstructionsearch-type_id').val(id);
            $('#advertisingconstructionsearch-address').val("");
            $('#advertisingconstructionsearch-size_id').val("");
            $('#w0').submit();
        }

        function getDateFrom() {
            return $('#advertisingconstructionsearch-fromdate').val();
        }

        function getDateTo() {
            return $('#advertisingconstructionsearch-todate').val();
        }

        function showSummary() {
            var selectedConstructions = getSelectedConstructions();
            if (!!selectedConstructions && selectedConstructions.length > 0) {
                window.location.href = '/construction/summary?ids=' + selectedConstructions.map(function (it) { return it.id; }).join(',') + '&q=' + vm.queryString;
            } else {
                window.location.href = '/construction/summary?' + vm.queryString;
            }
        }

        function getSelectedConstructions() {
            return vm.constructions.filter(function (it) {
                return it.isSelected;
            });
        }

        function showRequireAuthorizationModal() {
            $('#requireAuthorization').modal('show');
        }

        function buyConstructions() {
            if (!!isGuest) {
                showRequireAuthorizationModal();
                return;
            }

            if (isEmployee) {
                $('#company-selection').modal('show');
                return;
            }

            var model = {
                from: getDateFrom(),
                to: getDateTo(),
                ids: getSelectedConstructions().map(function (it) { return it.id; })
            };

            constructionsDataService.buyConstructions(model)
                .then(onConstructionReservationCreated);
        }

        function reservConstructions() {
            if (!!isGuest) {
                showRequireAuthorizationModal();
                return;
            }

            var model = {
                from: getDateFrom(),
                to: getDateTo(),
                ids: getSelectedConstructions().map(function (it) { return it.id; })
            };

            constructionsDataService.reservConstructions(model)
                .then(onConstructionReservationCreated);
        }

        function onConstructionReservationCreated() {
            window.location.href = '/shopping-cart/';
        }

        function getReport() {
            var params = {
                templateUrl: '/web/js/app/templates/selectReportPeriodModalTemplate.html',
                controller: 'selectReportPeriodModalCtrl',
                controllerAs: '$ctrl',
                size: 'md',
                resolve: {
                    constructions: getSelectedConstructions
                }
            };

            $uibModal.open(params);
        }
    }

    constructionsModule
        .controller('selectReportPeriodModalCtrl', selectReportPeriodModalCtrl);

    selectReportPeriodModalCtrl.$inject = ['constructions', '$uibModalInstance', '$window'];

    function selectReportPeriodModalCtrl(constructions, $uibModalInstance, $window) {
        var vm = this;

        vm.$onInit = init;
        vm.ok = ok;
        vm.cancel = cancel;

        function init() {

        }

        function ok() {
            window.location.href = GATEWAY_URLS.GET_REPORT;
            $uibModalInstance.close();
        }

        function cancel() {
            $uibModalInstance.dismiss();
        }
    }


    constructionsModule
        .service('constructionsDataService', constructionsDataService);

    constructionsDataService.$inject = ['$http'];

    function constructionsDataService($http) {
        var constructions = [];

        return {
            buyConstructions: buyConstructions,
            reservConstructions: reservConstructions,
            setSelectedConstructions: setSelectedConstructions,
            getSelectedConstructions: getSelectedConstructions
        };

        function buyConstructions(model) {
            return $http.post(GATEWAY_URLS.BUY_CONSTRUCTIONS, model);
        }

        function reservConstructions(model) {
            return $http.post(GATEWAY_URLS.RESERV_CONSTRUCTIONS, model);
        }

        function setSelectedConstructions(cs) {
            if (cs != null) {
                constructions = angular.copy(cs);
            } else {
                constructions = [];
            }
        }

        function getSelectedConstructions() {
            return constructions;
        }
    }

    if (isEmployee) {
        constructionsModule
            .controller('companyListCtrl', companyListCtrl);

        companyListCtrl.$inject = ['constructionsDataService', '$timeout', '$scope'];

        function companyListCtrl(constructionsDataService, $timeout, $scope) {
            var vm = this;

            vm.$onInit = init;
            vm.cancel = cancel;
            vm.buy = buy;
            vm.sortBy = sortBy;
            vm.selectCompany = selectCompany;

            function hideModal() {
                $('#company-selection').modal('hide');
            }

            function init() {
                vm.search = {};
                initializeModal();
                initializeWatchers();
            }

            function initializeWatchers() {
                $scope.$watch(function () { return vm.search; }, onSearchChanged, true);
            }

            function initializeModal() {
                vm.companies = angular.copy(companies);
                vm.selectedCompany = null;
                vm.reverse = true;
                vm.propertyName = null;
                vm.search.company = '';
            }

            function onSearchChanged() {
                vm.selectedCompany = null;
            }

            function sortBy(propertyName) {
                vm.reverse = (vm.propertyName === propertyName) ? !vm.reverse : false;
                vm.propertyName = propertyName;
            }

            function cancel() {
                vm.search.company = '';
                vm.selectedCompany = null;
                vm.reverse = true;
                vm.propertyName = null;
                $timeout(function () {
                    $('#company-selection').modal('hide');
                }, 0);

            }

            function buy() {
                if (!vm.selectedCompany) {
                    toastr.warning("Необходимо выбрать компанию.");
                    return;
                }

                var model = {
                    ids: constructionsDataService.getSelectedConstructions().map(function (it) { return it.id; }),
                    from: $('#advertisingconstructionsearch-fromdate').val(),
                    to: $('#advertisingconstructionsearch-todate').val(),
                    user_id: vm.selectedCompany.id
                };

                constructionsDataService.buyConstructions(model)
                    .then(function (response) {
                        var result = response.data;
                        if (result.isValid) {
                            window.location.href = '/shopping-cart/';
                            hideModal();
                        } else {
                            toastr.error(result.message);
                        }
                    })
            }

            function selectCompany(company) {
                vm.selectedCompany = company;
            }

        }
    }

})(constructions, constructionTypes, selectedConstructionType, isGuest, isEmployee);