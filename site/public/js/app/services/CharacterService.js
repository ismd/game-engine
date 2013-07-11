'use strict';

angular.module('characterService', []).factory('Character', function($q, $rootScope, $http, Ws, User, $window) {
    var service = {};

    var character;

    service.setCharacter = function(id) {
        var defer = $q.defer();

        Ws.send({
            controller: 'Character',
            action: 'set',
            args: {
                id: id,
                key: User.getAuthKey()
            }
        }).then(function(data) {
            if ('ok' !== data.status) {
                defer.reject(data.message);
                return;
            }

            character = data.character;
            $('div#select-character').modal('hide');

            $rootScope.$broadcast('set-character-success', data.character);
            defer.resolve(data.character);

            $http.post('/api/character/setId', {
                id: id
            });
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
