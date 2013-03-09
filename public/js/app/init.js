'use strict';

var main = angular.module('main', ['userServices', 'characterServices']);

main.config(function($routeProvider, $locationProvider, $httpProvider) {
    $locationProvider.html5Mode(true);

    $routeProvider.
        when('/', {
            templateUrl: '/partial/news'
        }).
        when('/registration', {
            templateUrl: '/partial/registration'
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
