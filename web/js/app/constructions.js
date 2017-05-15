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

    constructionsCtrl.$inject = ['$window', 'constructionsDataService'];

    function constructionsCtrl($window, constructionsDataService) {
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
            })
        }

        function getPriceForMonth(construction) {
            return (construction.price * 30).toFixed(2);
        }

        function selectConstruction(construction) {
            vm.selectedConstruction = construction;

            var index = _.findIndex(vm.constructions, { 'id': construction.id });
            vm.currentPage = Math.ceil(index/vm.ITEMS_PER_PAGE);
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
            window.location.href = '/construction/summary?' + vm.queryString;
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
    }

    constructionsModule
        .service('constructionsDataService', constructionsDataService);

    constructionsDataService.$inject = ['$http'];

    function constructionsDataService($http) {
        return {
            buyConstructions: buyConstructions,
            reservConstructions: reservConstructions
        };

        function buyConstructions(model) {
            return $http.post(GATEWAY_URLS.BUY_CONSTRUCTIONS, model);
        }

        function reservConstructions(model) {
            return $http.post(GATEWAY_URLS.RESERV_CONSTRUCTIONS, model);
        }
    }
})(constructions, constructionTypes, selectedConstructionType, isGuest, isEmployee);