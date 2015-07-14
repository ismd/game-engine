(function() {
    'use strict';

    window.mainModule.factory('Common', ['$location', '$route', '$timeout', '$rootScope',
                                         function($location, $route, $timeout, $rootScope) {
        var service = {};

        service.redirect = function(url) {
            if (url === $location.path()) {
                $route.reload();
            } else {
                $location.path(url);
            }

            $rootScope.$apply();
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
