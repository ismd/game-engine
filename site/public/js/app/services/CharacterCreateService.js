'use strict';

angular.module('characterCreateService', []).factory('CharacterCreate', function($q, Ws, Common) {
    var service = {};

    service.create = function(character) {
        var defer = $q.defer();

        Ws.send({
            controller: 'Character',
            action: 'create',
            args: {
                name: character.name
            }
        }).then(function(data) {
            defer.resolve(data.character);
        }, function(message) {
            defer.reject(message);
        });

        return defer.promise;
    };

    service.focus = function() {
        Common.focus($('input#name'));
    };

    return service;
});
