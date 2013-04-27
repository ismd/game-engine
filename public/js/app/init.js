'use strict';

angular.module('main', ['userService', 'characterService', 'mapService', 'registrationService', 'characterCreateService', 'worldService'])
    .config(function($routeProvider, $locationProvider, $httpProvider) {
        $locationProvider.html5Mode(true);

        $routeProvider.
            when('/', {
                templateUrl: '/partial/news'
            }).
            when('/registration', {
                templateUrl: '/partial/registration',
                controller: RegistrationCtrl
            }).
            when('/character/create', {
                templateUrl: '/partial/character/create',
                controller: CharacterCreateCtrl
            }).
            when('/world', {
                templateUrl: '/partial/world',
                controller: WorldCtrl
            }).
            when('/world/inventory', {
                templateUrl: '/partial/world/inventory'
            }).
            otherwise({
                redirectTo: '/'
            });

        $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
        $httpProvider.defaults.transformRequest = function(data) {
            if (data === undefined) {
                return data;
            }

            return $.param(data);
        };
    });

// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
};
