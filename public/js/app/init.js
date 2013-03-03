'use strict';

angular.module('main', []).
    config(function($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true);

        $routeProvider.
            when('/', {
                templateUrl: '/partial/news'
            }).
            when('/registration', {
                templateUrl: '/partial/registration'
            }).
            when('/world', {
                templateUrl: '/partial/world'
            }).
            when('/world/inventory', {
                templateUrl: '/partial/world/inventory'
            }).
            otherwise({
                redirectTo: '/'
            });
    });
