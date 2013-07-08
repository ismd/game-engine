'use strict';

angular.module('registrationService', []).factory('Registration', function($q, $http) {
    var service = {};

    service.register = function(data) {
        var defer = $q.defer();

        $http.post('/api/registration/register', data).success(function(data) {
            'ok' === data.status ? defer.resolve() : defer.reject(data.message);
        }).error(function() {
            defer.reject('Не удалось обратиться к серверу');
        });

        return defer.promise;
    };

    return service;
});
