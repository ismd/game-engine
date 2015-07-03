(function() {
    'use strict';

    $.extend($.scrollTo.defaults, {
        axis: 'y',
        duration: 500
    });

    window.mainModule = angular.module('main', ['ngRoute', 'angularFileUpload', 'ui.bootstrap'])
        .config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {
            $locationProvider.html5Mode(true);

            $routeProvider.
                when('/', {
                    templateUrl: '/partial/news/index.html'
                }).
                when('/registration', {
                    templateUrl: '/partial/registration/index.html',
                    controller: 'RegistrationCtrl'
                }).
                when('/character/create', {
                    templateUrl: '/partial/character/create.html',
                    controller: 'CharacterCreateCtrl'
                }).
                when('/world', {
                    templateUrl: '/partial/world/index.html',
                    controller: 'WorldCtrl'
                }).
                when('/world/inventory', {
                    templateUrl: '/partial/world/inventory.html'
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
        }]);
})();
