/**
 * Created by e.chernyavsky on 01.05.2017.
 */
function buildConstructionTimeline(reservations, elementId, zoomMin) {
    var RESERVATION_TYPES = {
        BOOKING: 'booking',
        RESERVATION: 'reservation'
    };

    var $timeline = document.getElementById(elementId);

    var items = reservations.map(function (reservation) {
        return {
            id: reservation.id,
            title: reservation.from + ' - ' + reservation.to,
            start: reservation.from,
            end: reservation.to,
            className: reservation.type == RESERVATION_TYPES.BOOKING ?
                'booked' :
                'reserved'
        };
    });

    zoomMin = zoomMin || 27592000000;

    var dataSet = new vis.DataSet(items);

    // Configuration for the Timeline
    var options = {
        format: {
            minorLabels: {
                month: 'MMMM'
            }
        },
        orientation: {
            axis: 'top'
        },
        rollingMode: true,
        selectable: false,
        stack: false,
        timeAxis: {
            scale: 'month'
        },
        tooltip: {
            followMouse: true,

        },
        zoomable: false,
        zoomMin: zoomMin
    };

    var timeline = new vis.Timeline($timeline, dataSet, options);
};