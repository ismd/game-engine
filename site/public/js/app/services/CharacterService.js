'use strict';

angular.module('characterService', []).factory('Character', function($q, $rootScope, $http, Ws, User, $window) {
    var service = {},
        character,
        requestSended = false,
        queue = [];

    service.setCharacter = function(id) {
        var defer = $q.defer();

        if (undefined === id) {
            defer.reject();
            return defer.promise;
        }

        if (requestSended) {
            queue.push(defer);
            return defer.promise;
        }

        requestSended = true;

        Ws.send({
            action: 'init',
            args: {
                id: id
            }
        }).then(function(data) {
            character = data.character;
            requestSended = false;
            $('div#select-character').modal('hide');

            $rootScope.$broadcast('set-character-success', character);
            defer.resolve(character);

            for (var i = 0; i < queue.length; i++) {
                queue[i].resolve(character);
            }

            $http.post('/api/character/setId', {
                id: id
            });
        }, function(message) {
            requestSended = false;
            defer.reject(message);
            User.logout();
        });

        return defer.promise;
    };

    service.getCharacter = function() {
        var defer = $q.defer();

        if (character) {
            defer.resolve(character);
        } else {
            service.setCharacter($window.idCharacter).then(function(character) {
                defer.resolve(character);
            });
        }

        return defer.promise;
    };

    return service;
});
