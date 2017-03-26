 /**
 * Created by gromi on 3/26/2017.
 */
(function ($, ajaxHelper) {
    var $buyBtn = $('#buy-btn'),
        $reservBtn = $('#reserv-btn'),
        model = {
            id: function () {
                return $('#advertisingconstruction-id').val();
            },
            dateFrom: function () {
                return $('#advertisingconstructionfastreservationform-fromdate').val();
            },
            dateTo: function () {
                return $('#advertisingconstructionfastreservationform-todate').val();
            }
        };

    $buyBtn.on('click', buyConstruction);
    $reservBtn.on('click', reservConstruction);

    function buyConstruction() {
        var submitModel = {
            id: model.id(),
            from: model.dateFrom(),
            to: model.dateTo()
        };

        ajaxHelper.post({
            url: GATEWAY_URLS.BUY_CONSTRUCTION,
            data: submitModel
        });
    }

    function reservConstruction() {

    }

})($, colorApp.utilities.ajaxHelper);