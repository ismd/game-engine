'use strict';

angular.module('redirectorService', []).factory('Redirector', function($location, $route) {
    var service = {};

    service.redirect = function(url) {
        if (url === $location.path()) {
            $route.reload();
        } else {
            $location.path(url);
        }
    };

    return service;
});
