var characterServices = angular.module('characterServices', []);

characterServices.factory('Character', function($rootScope, $http, $location) {
    return {
        'setCharacter': function(id) {
            $http.post('/api/character/set', {
                id: id
            }).success(function(data) {
                if ('ok' === data.status) {
                    $('div#select-character').modal('hide');
                    $rootScope.$broadcast('characterChosen', data.character);
                    $location.path('/world');
                } else {
                    alert('Ошибка');
                }
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        }
    };
});
