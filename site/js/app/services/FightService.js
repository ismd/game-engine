(function() {
    'use strict';

    window.mainModule.factory('Fight', ['$q', 'Ws', 'Chat',
                                        function($q, Ws, Chat) {
        var service = {};

        service.killMob = function(id) {
            var defer = $q.defer();

            Ws.send({
                controller: 'Fight',
                action: 'killMob',
                args: {
                    id: id
                }
            }).then(function(data) {
                defer.resolve(data);
            }, function(message) {
                Chat.addMessage(message);
                defer.reject(message);
            });

            return defer.promise;
        };

        service.getFightInfo = function() {
            var defer = $q.defer();

            Ws.send({
                controller: 'Fight',
                action: 'getInfo'
            }).then(function(data) {
                defer.resolve(data);
            }, function(message) {
                Chat.addMessage(message);
                defer.reject(message);
            });

            return defer.promise;
        };

        return service;
    }]);
})();
