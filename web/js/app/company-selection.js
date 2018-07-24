/**
 * Created by e.chernyavsky on 01.05.2017.
 */
(function (companies) {
    "use strict";

    var companyModule = angular.module('company', []);
    companyModule
        .config(appconfig);

    appconfig.$inject = ['$httpProvider'];

    function appconfig($httpProvider){
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr('content');
    }

    companyModule
        .controller('companyListCtrl', companyListCtrl);

    companyListCtrl.$inject = ['$scope', '$timeout', 'companyDataService'];

    function companyListCtrl($scope, $timeout, companyDataService) {
        var vm = this;

        vm.$onInit = init;
        vm.cancel = cancel;
        vm.onApproveBtnClick = onApproveBtnClick;
        vm.sortBy = sortBy;
        vm.selectCompany = selectCompany;
        vm.setTab = setTab;
        vm.getBtnName = getBtnName;
        vm.render = render;

        function render() {
            console.warn('Method need for rerender angular controller');
        }

        function setTab(tab) {
            vm.currentTab = tab;
            vm.search.company = '';
            vm.selectedCompany = null;
            if (vm.currentTab == vm.tabs[0]) {
                vm.tab.manage_id = vm.manageId;
            } else {
                vm.tab.manage_id = '';
            }
        }

        function init() {
            vm.search = {};
            vm.tab = {};
            vm.tabs = ['own', 'all'];
            initializeModal();
            initializeWatchers();

            vm.setTab(vm.tabs[0]);
        }

        function initializeWatchers() {
            $scope.$watch(function () { return vm.search; }, onSearchChanged, true);
        }

        function initializeModal() {
            vm.companies = angular.copy(companies);
            vm.manageId = angular.copy(manageId);
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

        function onApproveBtnClick() {
            var approveFunction = companyDataService.buyConstruction;
            if (currentMode === modes.reserv) {
                approveFunction = companyDataService.reservConstructions;
            }

            if (!vm.selectedCompany) {
                toastr.warning("Необходимо выбрать компанию.");
                return;
            }

            var model = {
                advertising_construction_id: $('#advertisingconstruction-id').val(),
                from: $('#advertisingconstructionfastreservationform-fromdate').val(),
                to: $('#advertisingconstructionfastreservationform-todate').val(),
                user_id: vm.selectedCompany.id
            };

            approveFunction(model)
                .then(function (response) {
                    var result = response.data;
                    if (result.isValid) {
                        toastr.success('Ваш заказ перемещен в корзину');
                        cancel();
                    } else {
                        toastr.error(result.message);
                    }
                })
        }

        function getBtnName() {
            return window.currentMode && window.currentMode.btnname;
        }

        function selectCompany(company) {
            vm.selectedCompany = company;
        }
    }

    companyModule
        .service('companyDataService', companyDataService);

    companyDataService.$inject = ['$http'];

    function companyDataService($http) {
        return {
            buyConstruction: buyConstruction,
            reservConstructions: reservConstructions
        };

        function buyConstruction(model) {
            return $http.post(GATEWAY_URLS.BUY_CONSTRUCTION, model);
        }

        function reservConstructions(model) {
            return $http.post(GATEWAY_URLS.RESERV_CONSTRUCTION, model);
        }
    }
})(companies, currentMode);