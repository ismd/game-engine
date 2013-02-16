require.config({
    baseUrl: '/js/lib',
    paths: {
        app: '/js/app'
    },
    shim: {
        'bootstrap': {
            deps: ['jquery']
        }
    }
});

require(['jquery', 'bootstrap', 'app/auth', 'app/select_character', 'app/map'],
function($, bootstrap, auth, select_character, map) {

});

define(['angular'], function(angulara) {
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
