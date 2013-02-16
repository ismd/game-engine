require.config({
    paths: {
        jquery: 'lib/jquery',
        bootstrap: 'lib/bootstrap',
        angular: 'lib/angular'
    },
    shim: {
        'bootstrap': {
            deps: ['jquery']
        }
    }
});

require(['bootstrap', 'app/auth'],
function (bootstrap,   auth) {

});

define(['angular'], function(a) {
    function RegistrationController($scope) {};
    function WorldController($scope) {};
    function InventoryController($scope) {};

    // Инициализируем маршруты
    return angular.module('main', []).
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
});
