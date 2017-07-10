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

colorApp.namespace('colorApp.utilities.urlHelper');
colorApp.utilities.urlHelper = (function () {
    return {
        getParameterByName: function (name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        },
        updateQueryString: function(key, value, url) {
            if (!url) url = window.location.href;
            var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
                hash;

            if (re.test(url)) {
                if (typeof value !== 'undefined' && value !== null)
                    return url.replace(re, '$1' + key + "=" + value + '$2$3');
                else {
                    hash = url.split('#');
                    url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                    if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                        url += '#' + hash[1];
                    return url;
                }
            }
            else {
                if (typeof value !== 'undefined' && value !== null) {
                    var separator = url.indexOf('?') !== -1 ? '&' : '?';
                    hash = url.split('#');
                    url = hash[0] + separator + key + '=' + value;
                    if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                        url += '#' + hash[1];
                    return url;
                }
                else
                    return url;
            }
        }
    }
})();

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

moment.locale('ru');