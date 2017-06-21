/**
 * Created by e.chernyavsky on 01.05.2017.
 */
(function (timelines) {
    var RESERVATION_TYPES = {
        BOOKING: 'booking',
        RESERVATION: 'reservation'
    };

    var $timeline = document.getElementById('timeline');

    var groups = [];
    var items = [];

    var mapReservation = function (reservation, groupId) {
        var title = reservation.company + '<br/><br/>';
        if (!!reservation.manager) {
            title += '- менеджер ' + reservation.manager + '<br/><br/>';
        }

        if (!!reservation.thematic) {
            title += '- ' + reservation.thematic + '<br/>';
        }

        if (!!reservation.marketing_type) {
            title += '- ' + reservation.marketing_type + '<br/><br/>'
        }

        title += reservation.from + ' - ' + reservation.to;

        return {
            id: reservation.id,
            title: title,
            start: reservation.from,
            end: reservation.to,
            group: groupId,
            className: reservation.type == RESERVATION_TYPES.BOOKING ?
                'booked' :
                'reserved'
        };
    };

    _.forEach(timelines, function (tl) {
        groups.push({
            id: tl.id,
            content: tl.address
        });

        _.forEach(tl.bookings, function (booking) {
            items.push(mapReservation(booking, tl.id));
        });

        _.forEach(tl.reservations, function (reservation) {
            items.push(mapReservation(reservation, tl.id));
        })
    });

    var dataSet = new vis.DataSet(items);

    // Configuration for the Timeline
    var options = {
        format: {
            minorLabels: {
                month: 'MMMM'
            }
        },
        groupTemplate: function (item, element, data) {
            return item.content + ' (<a href="/construction/details?id=' + item.id + '">подробнее</a>)';
        },
        // groupOrder: 'address',
        groupOrder: 'content',
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
            overflowMethod: 'flip',
            followMouse: true,

        },
        zoomable: false,
        zoomMin: 27592000000
    };

    var timeline = new vis.Timeline($timeline, dataSet, groups, options);

    $('#backToFilter').on('click', function () {
        var queryString = window.location.href.slice(window.location.href.indexOf('?') + 1)

        var q = window.location.href.split('&q=');
        var url = '/construction/index';
        if (q.length > 1) {
            url = url + '?' + q[1];
        } else {
            url = url + '?' + queryString;
        }

        window.location.href = url;
    });
})(timelines);