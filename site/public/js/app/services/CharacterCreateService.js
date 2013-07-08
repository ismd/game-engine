'use strict';

angular.module('characterCreateService', []).factory('CharacterCreate', function($q, $http) {
    var service = {};

    service.create = function(data) {
        var defer = $q.defer();

        $http.post('/api/character/create', data).success(function(data) {
            'ok' === data.status ? defer.resolve(data.id) : defer.reject(data.message);
        }).error(function() {
            defer.reject('Не удалось обратиться к серверу');
        });

        return defer.promise;
    };

    return service;
});
