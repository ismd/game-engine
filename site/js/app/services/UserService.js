(function() {
    'use strict';

    window.mainModule.factory('User', ['$q', 'Ws', '$rootScope', 'Common', function($q, Ws, $rootScope, Common) {
        var service = {};

        var $selectCharacterPopup = $('.js-select-character-popup');

        service.login = function(username, password) {
            var defer = $q.defer();

            Ws.send({
                controller: 'User',
                action: 'login',
                args: {
                    username: username,
                    password: password
                }
            }).then(function(data) {
                $('div#auth-form').modal('hide');

                localStorage.setItem('user', JSON.stringify(data.user));
                defer.resolve(data.user);
            }, function(message) {
                defer.reject(message);
            });

            return defer.promise;
        };

        service.loginByAuthKey = function(id, authKey) {
            var defer = $q.defer();

            var characterLocalStorage = localStorage.getItem('character'),
                character             = characterLocalStorage ? JSON.parse(characterLocalStorage) : null;

            Ws.send({
                controller: 'User',
                action: 'loginByAuthKey',
                args: {
                    id: id,
                    authKey: authKey,
                    idCharacter: null !== character ? character.id : null
                }
            }).then(function(data) {
                localStorage.setItem('user', JSON.stringify(data.user));
                localStorage.setItem('character', data.character ? JSON.stringify(data.character) : null);
                defer.resolve(data.user);
            }, function(message) {
                localStorage.setItem('user', null);
                localStorage.setItem('character', null);
                $rootScope.$broadcast('logout-success');
                defer.reject(message);
            });

            return defer.promise;
        };

        service.logout = function() {
            var defer = $q.defer();

            Ws.send({
                controller: 'User',
                action: 'logout'
            }).then(function() {
                defer.resolve();
            });

            return defer.promise;
        };

        service.showCharactersList = function() {
            var defer = $q.defer();

            $selectCharacterPopup.modal();

            Ws.send({
                controller: 'User',
                action: 'listCharacters'
            }).then(function(data) {
                defer.resolve(data.characters);
            }, function(message) {
                defer.reject(message);
            });

            return defer.promise;
        };

        service.focus = function() {
            Common.focus($('div#auth-form input[ng-model="username"]'));
        };

        return service;
    }]);
})();
