'use strict';

angular.module('registrationService', []).factory('Registration', function($q, Ws) {
    var service = {};

    service.register = function(user) {
        var defer = $q.defer();

        Ws.send({
            controller: 'User',
            action: 'register',
            args: {
                login: user.login,
                password: user.password,
                password1: user.password1,
                email: user.email,
                info: user.info,
                site: user.site
            }
        }).then(function(data) {
            defer.resolve(data.user);
        }, function(message) {
            defer.reject(message);
        });

        return defer.promise;
    };

    return service;
});
