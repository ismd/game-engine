(function() {
    'use strict';

    window.mainModule.factory('Common', ['$location', '$route', '$timeout', function($location, $route, $timeout) {
        var service = {};

        service.redirect = function(url) {
            if (url === $location.path()) {
                $route.reload();
            } else {
                $location.path(url);
            }
        };

        service.focus = function(element, value) {
            $timeout(function() {
                element.val(value);
                element.focus();
            });

            return element;
        };

        return service;
    }]);
})();
