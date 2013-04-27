'use strict';

angular.module('characterService', []).factory('Character', function($rootScope, $http, $location, $window) {
    var character = $window.character;

    return {
        'setCharacter': function(id) {
            $http.post('/api/character/set', {
                id: id
            }).success(function(data) {
                if ('ok' !== data.status) {
                    alert('Ошибка');
                    return;
                }

                character = data.character;

                $('div#select-character').modal('hide');
                $rootScope.$broadcast('character-chosen', character);
                $location.path('/world');
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        },
        'getCharacter': function() {
            return character;
        }
    };
});
