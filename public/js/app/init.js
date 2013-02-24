'use strict';

function RegistrationController($scope) {};
function WorldController($scope) {};
function InventoryController($scope) {};

angular.module('main', []).
    config(function($routeProvider, $locationProvider) {
        $locationProvider.html5Mode(true);

        $routeProvider.
            when('/', {
                templateUrl: '/partial/news'
            }).
            when('/registration', {
                templateUrl: '/partial/registration',
                controller: RegistrationController
            }).
            when('/world', {
                templateUrl: '/partial/world',
                controller: WorldController
            }).
            when('/world/inventory', {
                templateUrl: '/partial/world/inventory',
                controller: InventoryController
            }).
            otherwise({
                redirectTo: '/'
            });
    });
