'use strict';

angular.module('characterService', []).factory('Character', function($q, $rootScope, $http, $window) {
    var service = {};

    var character = $window.character;

    service.setCharacter = function(id) {
        var defer = $q.defer();

        $http.post('/api/character/set', {
            id: id
        }).success(function(data) {
            if ('ok' !== data.status) {
                defer.reject(data.message);
                return;
            }

            character = data.character;
            $('div#select-character').modal('hide');

            $rootScope.$broadcast('set-character-success', data.character);
            defer.resolve(data.character);
        }).error(function() {
            defer.reject('Не удалось обратиться к серверу');
        });

        return defer.promise;
    };

    service.getCharacter = function() {
        return character;
    };

    return service;
});
