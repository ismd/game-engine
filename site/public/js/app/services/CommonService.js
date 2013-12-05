'use strict';

angular.module('commonService', []).factory('Common', function($location, $route) {
    var service = {};

    service.redirect = function(url) {
        if (url === $location.path()) {
            $route.reload();
        } else {
            $location.path(url);
        }
    };

    service.focus = function(element, value) {
        element.val(value).focus();
        return element;
    };

    return service;
});
