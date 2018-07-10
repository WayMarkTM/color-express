/**
 * Created by e.chernyavsky on 01.05.2017.
 */
(function (companies, manageId) {
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
        vm.buy = buy;
        vm.sortBy = sortBy;
        vm.selectCompany = selectCompany;
        vm.setTab = setTab;

        function setTab(tab) {
            vm.currentTab = tab;
            vm.search.company = '';
            if (vm.currentTab == vm.tabs[0]) {
                vm.tab.manage_id = vm.manageId;
            } else {
                vm.tab.manage_id = '';
            }
        }

        function hideModal() {
            $('#company-selection').modal('hide');
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

        function buy() {
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

            companyDataService.buyConstruction(model)
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
            console.log(123);
            debugger;
            vm.selectedCompany = company;
        }
    }

    companyModule
        .service('companyDataService', companyDataService);

    companyDataService.$inject = ['$http'];

    function companyDataService($http) {
        return {
            buyConstruction: buyConstruction
        };

        function buyConstruction(model) {
            return $http.post(GATEWAY_URLS.BUY_CONSTRUCTION, model);
        }
    }
})(companies, manageId);