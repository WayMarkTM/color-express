/**
 * Created by e.chernyavsky on 01.05.2017.
 */
(function (reservations) {
    var RESERVATION_TYPES = {
        BOOKING: 'booking',
        RESERVATION: 'reservation'
    };

    var $timeline = document.getElementById('timeline');

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
        zoomMin: 27592000000
    };

    var timeline = new vis.Timeline($timeline, dataSet, options);
})(reservations);