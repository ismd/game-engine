'use strict';

angular.module('userService', []).factory('User', function($q, $rootScope, $http, Redirector, $window, Ws) {
    var service = {};
    var authKey = $window.authKey;

    service.login = function(username, password) {
        var defer = $q.defer();

        $http.post('/api/auth/login', {
            username: username,
            password: password
        }).success(function(data) {
            if ('ok' !== data.status) {
                defer.reject(data.message);
                return;
            }

            authKey = data.key;

            $('div#auth-form').modal('hide');
            defer.resolve(data.user);
            $rootScope.$broadcast('login-success', data.user);
        }).error(function() {
            defer.reject('Не удалось обратиться к серверу');
        });

        return defer.promise;
    };

    service.logout = function() {
        var defer = $q.defer();

        Ws.send({
            action: 'logout'
        }).then(function() {
            $http.post('/api/auth/logout').success(function(data) {
                if ('ok' !== data.status) {
                    defer.reject();
                    return;
                }

                $rootScope.$broadcast('logout-success');
                Redirector.redirect('/');
                defer.resolve();
            }).error(function() {
                defer.reject('Не удалось обратиться к серверу');
            });
        });

        return defer.promise;
    };

    service.showCharactersList = function() {
        var defer = $q.defer();

        $('div#select-character').modal();

        $http.get('/api/user/characters').success(function(data) {
            defer.resolve(data);
        }).error(function() {
            defer.reject('Не удалось обратиться к серверу');
        });

        return defer.promise;
    };

    service.getAuthKey = function() {
        return authKey;
    };

    return service;
});
