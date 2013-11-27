'use strict';

angular.module('characterService', []).factory('Character', function($q, Ws) {
    var service = {};

    service.setCharacter = function(id) {
        var defer = $q.defer();

        Ws.send({
            controller: 'Character',
            action: 'set',
            args: {
                id: id
            }
        }).then(function(data) {
            $('div#select-character').modal('hide');
            defer.resolve(data.character);
        }, function(message) {
            defer.reject(message);
        });

        return defer.promise;
    };

    service.move = function(idLayout, x, y) {
        var defer = $q.defer();

        Ws.send({
            controller: 'Character',
            action: 'move',
            args: {
                idLayout: idLayout,
                x: x,
                y: y
            }
        }).then(function(data) {
            defer.resolve(data.cell);
        }, function(message) {
            defer.reject(message);
        });

        return defer.promise;
    };

    return service;
});
