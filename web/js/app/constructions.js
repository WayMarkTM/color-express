(function (constructions, constructionTypes, selectedConstructionType) {
    "use strict";

    var constructionsModule = angular.module('constructions', []);

    constructionsModule
        .controller('constructionsCtrl', constructionsCtrl);

    constructionsCtrl.$inject = [];

    function constructionsCtrl() {
        var vm = this;

        vm.$onInit = init;
        vm.showSummary = showSummary;
        vm.buyConstructions = buyConstructions;
        vm.reservConstructions = reservConstructions;
        vm.showSummary = showSummary;
        vm.selectConstructionType = selectConstructionType;

        function init() {
            vm.constructions = constructions;
            vm.constructionTypes = [];
            vm.selectedConstructionType = selectedConstructionType;
            _.forEach(constructionTypes, function (type, key) {
                vm.constructionTypes.push({
                    id: key,
                    name: type
                });
            });

        }

        function selectConstructionType(id) {
            vm.selectedConstructionType = id;
            $('#advertisingconstructionsearch-type_id').val(id);
            $('#w0').submit();
        }

        function showSummary() {
            var queryString = window.location.href.slice(window.location.href.indexOf('?') + 1)
            window.location.href = '/construction/summary?' + queryString;
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