'use strict';

angular.module('characterService', []).factory('Character', function($q, $rootScope, $http, $window, Ws, User) {
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
        });

        return defer.promise;
    };

    service.getCharacter = function() {
        var defer = $q.defer();

        if (!character) {
            Ws.send({
                controller: 'Character',
                action: 'getCurrent'
            }).then(function(data) {
                character = data.character;
                defer.resolve(character);
            });
        } else {
            defer.resolve(character);
        }

        return defer.promise;
    };

    return service;
});
