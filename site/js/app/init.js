(function() {
    'use strict';

    $.extend($.scrollTo.defaults, {
        axis: 'y',
        duration: 500
    });

    window.mainModule = angular.module('main', ['ngRoute', 'angularFileUpload', 'ui.bootstrap'])
        .config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {
            $locationProvider.html5Mode(true);

            $routeProvider
                .when('/', {
                    templateUrl: '/partial/news/index.html'
                })
                .when('/registration', {
                    controller: 'RegistrationCtrl',
                    templateUrl: '/partial/registration/index.html'
                })
                .when('/character/create', {
                    controller: 'CharacterCreateCtrl',
                    templateUrl: '/partial/character/create.html'
                })
                .when('/world/character', {
                    templateUrl: '/partial/world/character.html'
                })
                .when('/world/inventory', {
                    templateUrl: '/partial/world/inventory.html'
                })
                .when('/world/fight', {
                    controller: 'FightCtrl',
                    templateUrl: '/partial/world/fight.html'
                })
                .when('/world', {
                    controller: 'WorldCtrl',
                    templateUrl: '/partial/world/index.html'
                })
                .otherwise({
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
