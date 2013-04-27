'use strict';

angular.module('userService', []).factory('User', function($rootScope, $http, $location) {
    return {
        'login': function(username, password) {
            var authForm    = $('div#auth-form');
            var loginButton = $('button#login-button');

            loginButton.addClass('disabled');

            $http.post('/api/auth/login', {
                username: username,
                password: password
            }).success(function(data) {
                if ('ok' !== data.status) {
                    alert('Не удалось войти');
                    loginButton.removeClass('disabled');
                    return;
                }

                $rootScope.$broadcast('logged', true);
                $rootScope.$broadcast('setUser', data.user);

                authForm.modal('hide');
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        },
        'logout': function() {
            $http.post('/api/auth/logout').success(function(data) {
                if ('ok' !== data.status) {
                    alert('Не удалось выйти');
                    return;
                }

                $rootScope.$broadcast('logged', false);
                $location.path('/');
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });;
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
