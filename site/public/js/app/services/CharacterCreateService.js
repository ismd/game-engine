'use strict';

angular.module('characterCreateService', []).factory('CharacterCreate', function($rootScope, $http) {
    var service = {};

    service.create = function(data) {
        $http.post('/api/character/create', data).success(function(data) {
            $rootScope.$broadcast('character-created', 'ok' === data.status, data.message, data.id);
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    };

    return service;
});
