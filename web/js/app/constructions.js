(function (constructions, constructionTypes, selectedConstructionType) {
    "use strict";

    var constructionsModule = angular.module('constructions', ['yaMap']);

    constructionsModule
        .controller('constructionsCtrl', constructionsCtrl);

    constructionsCtrl.$inject = ['$window'];

    function constructionsCtrl($window) {
        var vm = this;

        vm.$onInit = init;
        vm.showSummary = showSummary;
        vm.buyConstructions = buyConstructions;
        vm.reservConstructions = reservConstructions;
        vm.showSummary = showSummary;
        vm.selectConstructionType = selectConstructionType;
        vm.selectConstruction = selectConstruction;

        function init() {
            vm.constructions = constructions;
            vm.constructionTypes = [];
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

        function selectConstruction(construction) {
            vm.selectedConstruction = construction;
        }

        function selectConstructionType(id) {
            vm.selectedConstructionType = id;
            $('#advertisingconstructionsearch-type_id').val(id);
            $('#advertisingconstructionsearch-address').val("");
            $('#advertisingconstructionsearch-size_id').val("");
            $('#w0').submit();
        }

        function showSummary() {
            window.location.href = '/construction/summary?' + vm.queryString;
        }

        function getSelectedConstructions() {
            return vm.constructions.filter(function (it) {
                return it.isSelected;
            });
        }

        function buyConstructions() {
            alert(getSelectedConstructions().map(function(it) { return it.id; }));
        }

        function reservConstructions() {

        }

    }
})(constructions, constructionTypes, selectedConstructionType);