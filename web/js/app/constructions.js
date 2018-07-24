(function (constructions, constructionTypes, selectedConstructionType, isGuest, isEmployee, isDatesSet, isAgency, agencyCharge) {
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

    constructionsModule.constant('months', MONTHS);


    constructionsModule
        .controller('constructionsCtrl', constructionsCtrl);

    var modes = {
        buy: {
            btnname: 'Купить'
        },
        reserv: {
            btnname: 'Зарезервировать'
        }
    };
    var currentMode;


    constructionsCtrl.$inject = ['$window', 'constructionsDataService', '$scope', '$uibModal'];

    function constructionsCtrl($window, constructionsDataService, $scope, $uibModal) {
        var vm = this;

        vm.$onInit = init;
        vm.showSummary = showSummary;
        vm.buyConstructions = buyConstructions;
        vm.reservConstructions = reservConstructions;
        vm.selectConstructionType = selectConstructionType;
        vm.selectConstruction = selectConstruction;
        vm.getPriceForMonth = getPriceForMonth;
        vm.getConstructionStatus = getConstructionStatus;
        vm.showRequireAuthorizationModal = showRequireAuthorizationModal;
        vm.getSelectedConstructions = getSelectedConstructions;
        vm.getReport = getReport;
        vm.getPricePerDay = getPricePerDay;
        vm.getQueryString = getQueryString;

        function init() {
            vm.PAGE_NUMBER_PARAM = 'page-number';
            vm.isEmployee = isEmployee;
            vm.isAgency = isAgency;
            vm.isGuest = isGuest;
            vm.constructions = constructions;
            vm.constructionTypes = [];
            vm.currentPage = colorApp.utilities.urlHelper.getParameterByName(vm.PAGE_NUMBER_PARAM) || 1;
            vm.ITEMS_PER_PAGE = 7;
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
                            '<img class="info-window-image-preview" src="/' + construction.previewImage + '"/><br/><a href="/construction/details?id=' + construction.id + '"/>Подробнее</a>'
                            : '')
                    }
                };
            });

            $scope.$watch(function () { return vm.getSelectedConstructions(); }, onSelectedConstructionChanged, true);
        }

        function getQueryString() {
            var url = colorApp.utilities.urlHelper.updateQueryString(vm.PAGE_NUMBER_PARAM, vm.currentPage);
            return url.slice(url.indexOf('?') + 1);
        }

        function onSelectedConstructionChanged() {
            constructionsDataService.setSelectedConstructions(vm.getSelectedConstructions());
        }

        function getPricePerDay(construction) {
            var charge = isAgency ? agencyCharge : 0;
            return (construction.price * (100-charge)/100).toFixed(2);
        }

        function getPriceForMonth(construction) {
            var charge = isAgency ? agencyCharge : 0;
            return (construction.price * (100-charge)/100 * 30).toFixed(2);
        }

        function getConstructionStatus(construction) {
            if (isDatesSet) {
                return construction.isBusy ? 'занята' : 'свободна';
            }

            return '-'
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
                window.location.href = '/construction/summary?ids=' + selectedConstructions.map(function (it) { return it.id; }).join(',') + '&q=' + getQueryString();
            } else {
                window.location.href = '/construction/summary?' + getQueryString();
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
                currentMode = modes.buy;
                $('#company-selection').modal('show');
                return;
            }

            var model = {
                from: getDateFrom(),
                to: getDateTo(),
                ids: getSelectedConstructions().map(function (it) { return it.id; })
            };

            constructionsDataService.buyConstructions(model)
                .then(function() {
                    onConstructionReservationCreated();
                    constructionsDataService.clearSelectedConstructions();
                });
        }

        function reservConstructions() {
            if (!!isGuest) {
                showRequireAuthorizationModal();
                return;
            }

            if (isEmployee) {
                currentMode = modes.reserv;
                $('#company-selection').modal('show');
                return;
            }

            var model = {
                from: getDateFrom(),
                to: getDateTo(),
                ids: getSelectedConstructions().map(function (it) { return it.id; })
            };

            constructionsDataService.reservConstructions(model)
                .then(function() {
                    onConstructionReservationCreated();
                    constructionsDataService.clearSelectedConstructions();
                });
        }

        function onConstructionReservationCreated() {
            toastr.success('Ваш заказ перемещен в корзину');
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

    selectReportPeriodModalCtrl.$inject = ['constructions', '$uibModalInstance', 'months'];

    function selectReportPeriodModalCtrl(constructions, $uibModalInstance, months) {
        var vm = this;

        vm.$onInit = init;
        vm.ok = ok;
        vm.cancel = cancel;

        function init() {
            vm.reportTypes = {
                BUSY: '1',
                STATUS: '2'
            };

            vm.months = months;

            vm.periods = [{
                id: 1,
                text: '1 месяц (ежемесячный)'
            }, {
                id: 3,
                text: '3 месяца (ежеквартальный)'
            }, {
                id: 12,
                text: '12 месяцев (годовой)'
            }];

            vm.model = {
                type: vm.reportTypes.BUSY,
                from: vm.months[(new Date()).getMonth()],
                year: 1900 + (new Date()).getYear(),
                period: vm.periods[0]
            };
        }

        function ok() {
            var url = GATEWAY_URLS.GET_REPORT + '?type=' + vm.model.type + '&year=' + vm.model.year + '&from=' + vm.model.from.id + '&period=' + vm.model.period.id;

            if (constructions.length > 0) {
                url += '&ids=' + constructions.map(function (it) { return it.id; }).join(',');
            }

            url += '&' +  window.location.href.slice(window.location.href.indexOf('?') + 1);

            window.location.href = url;
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
        var _constructions = [];

        return {
            buyConstructions: buyConstructions,
            reservConstructions: reservConstructions,
            setSelectedConstructions: setSelectedConstructions,
            getSelectedConstructions: getSelectedConstructions,
            clearSelectedConstructions: clearSelectedConstructions,
        };

        function buyConstructions(model) {
            return $http.post(GATEWAY_URLS.BUY_CONSTRUCTIONS, model);
        }

        function reservConstructions(model) {
            return $http.post(GATEWAY_URLS.RESERV_CONSTRUCTIONS, model);
        }

        function setSelectedConstructions(cs) {
            if (cs != null) {
                _constructions = angular.copy(cs);
            } else {
                _constructions = [];
            }
        }

        function getSelectedConstructions() {
            return _constructions;
        }

        function clearSelectedConstructions() {
            constructions.forEach(function (construction) {
                construction.isSelected = false;
            });
            setSelectedConstructions([]);
        }
    }

    if (isEmployee) {
        constructionsModule
            .controller('companyListCtrl', companyListCtrl);

        companyListCtrl.$inject = ['constructionsDataService', '$timeout', '$scope'];

        //noinspection JSAnnotator
        function companyListCtrl(constructionsDataService, $timeout, $scope) {
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
                var approveFunction = constructionsDataService.buyConstructions;
                if (currentMode === modes.reserv) {
                    approveFunction = constructionsDataService.reservConstructions;
                }

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

                approveFunction(model)
                    .then(function (response) {
                        var result = response.data;
                        if (result.isValid) {
                            toastr.success('Ваш заказ перемещен в корзину');
                            constructionsDataService.clearSelectedConstructions();
                            cancel();
                        } else {
                            toastr.error(result.message);
                        }
                    })
            }

            function getBtnName() {
                return currentMode && currentMode.btnname;
            }

            function selectCompany(company) {
                vm.selectedCompany = company;
            }

        }
    }

})(constructions, constructionTypes, selectedConstructionType, isGuest, isEmployee, isDatesSet, isAgency, agencyCharge);