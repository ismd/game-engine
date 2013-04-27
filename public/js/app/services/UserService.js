'use strict';

angular.module('userService', []).factory('User', function($rootScope, $http, $location) {
    return {
        'login': function(username, password) {
            $http.post('/api/auth/login', {
                username: username,
                password: password
            }).success(function(data) {
                // Скрываем форму авторизации
                if ('ok' === data.status) {
                    $('div#auth-form').modal('hide');
                }
                
                $rootScope.$broadcast('login-result', 'ok' === data.status, data.message);
                $rootScope.$broadcast('set-user', data.user);
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
            $('div#select-character').modal();

            $http.get('/api/user/characters').success(function(data) {
                $rootScope.$broadcast('characters-list-update', data);
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        }
    };
});
