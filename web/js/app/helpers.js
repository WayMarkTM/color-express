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
            var d = jQuery.Deferred();

            ajax(options.url, options.data, "POST")
                .done(function (response) {
                    if (response) {
                        d.resolve(response.data);
                    } else {
                        d.reject(response);
                    }
                })
                .fail(function () {
                    d.reject();
                });

            return d;
        }
    }
})($);