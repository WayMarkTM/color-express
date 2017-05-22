/**
 * Created by e.chernyavsky on 08.05.2017.
 */
(function (cartItems, marketingTypes, isEmployee) {
    "use strict";

    Date.prototype.addDays = function(days) {
        var dat = new Date(this.valueOf());
        dat.setDate(dat.getDate() + days);
        return dat;
    };

    var shoppingCartModule = angular.module('shoppingCart', ['ui.bootstrap']);

    shoppingCartModule
        .config(appconfig);

    appconfig.$inject = ['$httpProvider'];

    function appconfig($httpProvider){
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr('content');
    }

    shoppingCartModule
        .controller('shoppingCartCtrl', shoppingCartCtrl);

    shoppingCartCtrl.$inject = ['shoppingCartDataService', '$uibModal', '$timeout'];

    function shoppingCartCtrl(shoppingCartDataService, $uibModal, $timeout) {
        var vm = this;

        vm.$onInit = init;
        vm.getTotalCost = getTotalCost;
        vm.onItemMarketingTypeChanged = onItemMarketingTypeChanged;
        vm.submit = submit;
        vm.editPeriod = editPeriod;
        vm.removeItem = removeItem;
        vm.getReservationTillDate = getReservationTillDate;
        vm.getItemCost = getItemCost;

        function init() {
            vm.cartItems = cartItems;
            vm.isEmployee = isEmployee;
            vm.marketingTypes = marketingTypes;

            _.forEach(vm.cartItems, function (item) {
                item.marketing_type_id = vm.marketingTypes[0].id.toString();
                item.from = convertToCurrentFormat(new Date(item.from));
                item.to = convertToCurrentFormat(new Date(item.to));
            });
        }

        function getReservationTillDate(createdDate) {
            var date = new Date(createdDate);
            return convertToCurrentFormat(date.addDays(5));
        }

        function getTotalCost() {
            return _.sumBy(vm.cartItems, function (item) {
                return parseFloat(item.cost);
            });
        }

        function onItemMarketingTypeChanged(item) {
            if (!item.marketing_type_id) {
                item.cost = item.price;
            }

            item.cost = getItemCost(item);
        }

        function getItemMarketingTypeCharge(item) {
            var marketingType = _.find(vm.marketingTypes, { 'id': parseInt(item.marketing_type_id) });
            return marketingType.charge + 100;
        }

        function getItemCost(item) {
            var charge = getItemMarketingTypeCharge(item);

            var to = new Date(item.to);
            var from = new Date(item.from);
            var days = (to - from)/(1000*60*60*24) + 1;

            return (days * (item.price * charge / 100)).toFixed(2);
        }

        function submit() {
            if (!vm.form.$valid) {
                toastr.warning('Необходимо заполнить поле "Тематика сюжета".');
                return;
            }

            shoppingCartDataService.checkout(vm.cartItems, vm.thematic)
                .then(function (response) {
                    if (response.data.isValid) {
                        toastr.success('Спасибо, Ваша заявка принята в работу. Подтверждение будет отправлено на е-мейл.');
                        $timeout(function () {
                            window.location.href = '/construction/index';
                        }, 1500);
                    } else {
                        toastr.error(response.data.messages.join('\n'));
                        $timeout(function () {
                            window.location.reload();
                        }, 1500);
                    }
                });
        }

        function editPeriod(item) {
            var params = {
                templateUrl: '/web/js/app/templates/editPeriodModalTemplate.html',
                controller: 'editPeriodModalCtrl',
                controllerAs: '$ctrl',
                size: 'md',
                resolve: {
                    reservation: function () {
                        return angular.copy(item);
                    }
                }
            };

            shoppingCartDataService.getConstructionReservations(item.advertising_construction_id)
                .then(function (response) {
                    params.resolve.reservations = function () { return response.data.reservations; };

                    $uibModal.open(params).result.then(function (result) {
                        onPeriodChanged(item, result);
                    });
                });
        }

        function onPeriodChanged(item, result) {
            item.from = convertToCurrentFormat(result.from);
            item.to = convertToCurrentFormat(result.to);
            item.cost = getItemCost(item);
        }

        function convertToCurrentFormat(date) {
            return date.toJSON().split('T')[0];
        }

        function removeItem(item) {
            shoppingCartDataService.removeShoppingCartItem(item.id)
                .then(function () {
                    onItemDeleted(item);
                })
                .catch(onItemDeletionFailed);
        }

        function onItemDeleted(item) {
            var index = _.findIndex(vm.cartItems, { 'id': item.id });
            vm.cartItems.splice(index, 1);
            toastr.success("Элемент корзины успешно удален.");
        }

        function onItemDeletionFailed() {
            toastr.error("Серверная ошибка. Невозможно удалить элемент из корзины. Обратитесь к системному администратору");
        }
    }

    shoppingCartModule
        .controller('editPeriodModalCtrl', editPeriodModalCtrl);

    editPeriodModalCtrl.$inject = ['$uibModalInstance', 'reservation', 'reservations', '$timeout', 'shoppingCartDataService'];

    function editPeriodModalCtrl($uibModalInstance, reservation, reservations, $timeout, shoppingCartDataService) {
        var vm = this;

        vm.$onInit = init;
        vm.ok = ok;
        vm.cancel = cancel;

        function init() {
            vm.model = {
                advertising_construction_id: reservation.advertising_construction_id,
                from: new Date(reservation.from),
                to: new Date(reservation.to)
            };

            vm.format = 'dd.MM.yyyy';
            vm.dateOptions = {};

            if (!isEmployee) {
                vm.dateOptions.minDate = new Date();
            }

            $timeout(function () {
                buildConstructionTimeline(reservations, 'timeline', 17592000000);
            }, 0);
        }

        function ok() {
            if (!vm.form.$valid) {
                return;
            }

            if (vm.model.from > vm.model.to) {
                toastr.warning('Дата "с" должна быть раньше даты "по".');
                return;
            }

            return shoppingCartDataService.validateDateRange(vm.model)
                .then(function (response) {
                    if (response.data.isValid) {
                        return $uibModalInstance.close({
                            from: vm.model.from,
                            to: vm.model.to
                        });
                    } else {
                        toastr.error(response.data.message);
                    }
                });
        }

        function cancel() {
            return $uibModalInstance.dismiss();
        }
    }

    shoppingCartModule
        .service('shoppingCartDataService', shoppingCartDataService);

    shoppingCartDataService.$inject = ['$http'];

    function shoppingCartDataService($http) {
        return {
            getConstructionReservations: getConstructionReservations,
            validateDateRange: validateDateRange,
            checkout: checkout,
            removeShoppingCartItem: removeShoppingCartItem
        };

        function removeShoppingCartItem(id) {
            return $http.get(GATEWAY_URLS.DELETE_SHOPPING_CART_ITEM + '?id=' + id);
        }

        function getConstructionReservations(constructionId) {
            return $http.get(GATEWAY_URLS.GET_CONSTRUCTION_RESERVATIONS + '?constructionId=' + constructionId);
        }

        function validateDateRange(model) {
            return $http.post(GATEWAY_URLS.VALIDATE_CONSTRUCTION_DATE_RANGE, model);
        }

        function checkout(cartItems, thematic) {
            return $http.post(GATEWAY_URLS.CHECKOUT, {
                reservations: cartItems,
                thematic: thematic
            });
        }
    }
})(cartItems, marketingTypes, isEmployee);