angular.module('authServices', []).
    factory('Auth', function($rootScope) {
        var service = {};

        service.logged = false;
        service.setLogged = function(logged) {
            this.logged = logged;
            $rootScope.$broadcast('logged');
        }

        return service;
    });
