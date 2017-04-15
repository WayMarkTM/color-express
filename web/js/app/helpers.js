/**
 * Created by gromi on 3/26/2017.
 */

var colorApp = colorApp || {};

colorApp.namespace = function (nsString) {
    var parts = nsString.split('.'),
        parent = colorApp,
        i;
    if (parts[0] === "colorApp") {
        parts = parts.slice(1);
    }

    for (i = 0; i < parts.length; i += 1) {
        if (typeof parent[parts[i]] === "undefined") {
            parent[parts[i]] = {};
        }
        parent = parent[parts[i]];
    }
    return parent;
};

colorApp.namespace('colorApp.utilities.ajaxHelper');
colorApp.utilities.ajaxHelper = (function (jQuery) {
    var ajax = function (url, data, type) {
        return jQuery.ajax({
            url: url,
            type: type,
            data: data
        });
    };

    return {
        post: function (options) {
            return ajax(options.url, options.data, "POST");
        },
        get: function (options) {
            return ajax(options.url, null, "GET");
        }
    }
})($);

colorApp.namespace('colorApp.utilities.dateHelper');
colorApp.utilities.dateHelper = (function () {
    return {
        getMonthsNames: function () {
            return {
                1: 'Январь',
                2: 'Февраль',
                3: 'Март',
                4: 'Апрель',
                5: 'Май',
                6: 'Июнь',
                7: 'Июль',
                8: 'Август',
                9: 'Сентябрь',
                10: 'Октябрь',
                11: 'Ноябрь',
                12: 'Декабрь'
            }
        }
    }
})();