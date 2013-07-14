'use strict';

angular.module('characterService', []).factory('Character', function($q, $rootScope, $http, Ws, User, $window) {
    var service = {};

    var character;
    var requestSended = false;
    var queue = [];

    service.setCharacter = function(id) {
        var defer = $q.defer();

        if (requestSended) {
            queue.push(defer);
            return defer.promise;
        }

        requestSended = true;

        Ws.send({
            controller: 'Character',
            action: 'set',
            args: {
                id: id,
                key: User.getAuthKey()
            }
        }).then(function(data) {
            character = data.character;
            requestSended = false;
            $('div#select-character').modal('hide');

            $rootScope.$broadcast('set-character-success', data.character);
            defer.resolve(data.character);

            for (var i = 0; i < queue.length; i++) {
                queue[i].resolve(data.character);
            }

            $http.post('/api/character/setId', {
                id: id
            });
        }, function(data, message) {
            defer.reject(message);
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
