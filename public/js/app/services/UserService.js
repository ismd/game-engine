'use strict';

angular.module('userService', []).factory('User', function($rootScope, $http, $location) {
    return {
        'login': function(username, password) {
            var authForm = $('div#auth-form');

            $http.post('/api/auth/login', {
                username: username,
                password: password
            }).success(function(data) {
                $rootScope.$broadcast('login-result', 'ok' === data.status, data.message);
                $rootScope.$broadcast('set-user', data.user);

                if ('ok' === data.status) {
                    authForm.modal('hide');
                }
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        },
        'logout': function() {
            $http.post('/api/auth/logout').success(function(data) {
                $rootScope.$broadcast('logout-result', 'ok' === data.status);

                if ('ok' === data.status) {
                    $location.path('/');
                }
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        },
        'showCharactersList': function() {
            var selectCharacterForm = $('div#select-character');

            selectCharacterForm.modal();

            $http.get('/api/user/characters').success(function(data) {
                $rootScope.$broadcast('characters-list-update', data);
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        }
    };
});
