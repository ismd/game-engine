'use strict';

angular.module('characterService', []).factory('Character', function($rootScope, $http, $window) {
    var service = {};

    var character = $window.character;

    service.setCharacter = function(id) {
        $http.post('/api/character/set', {
            id: id
        }).success(function(data) {
            if ('ok' === data.status) {
                character = data.character;
                $('div#select-character').modal('hide');
            }

            $rootScope.$broadcast('set-character-result', 'ok' === data.status, data.message, data.character);
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    };

    service.getCharacter = function() {
        return character;
    };

    return service;
});
