'use strict';

angular.module('chatService', []).factory('Chat', function(Ws, $q) {
    var service = {};

    service.send = function(message) {
        var defer = $q.defer();

        Ws.send({
            controller: 'Chat',
            action: 'send',
            args: {
                message: message
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
