var characterServices = angular.module('characterServices', []);

/**
 * Список персонажей пользователя
 */
characterServices.factory('Character', function($rootScope, $http) {
    return {
        'setCharacter': function(id) {
            $http.post('/api/character/set', {
                id: id
            }).success(function(data) {
                if ('ok' === data.status) {
                    $rootScope.$broadcast('characterChosen', data.character);
                } else {
                    alert('Ошибка');
                }
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        }
    };
});
