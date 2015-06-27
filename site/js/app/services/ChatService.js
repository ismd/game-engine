(function() {
    'use strict';

    window.mainModule.factory('Chat', ['Ws', '$q', 'Common', function(Ws, $q, Common) {
        var service = {};

        var $chatMessages = $('.js-chat-messages'),
            $messageText  = $('.js-message-text');

        service.init = function() {
            var defer = $q.defer();

            Ws.send({
                controller: 'Chat',
                action: 'init'
            }).then(function(data) {
                defer.resolve(data);
            }, function(message) {
                defer.reject(message);
            });

            return defer.promise;
        };

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

        service.getMembers = function() {
            var defer = $q.defer();

            Ws.send({
                controller: 'Chat',
                action: 'getMembers'
            }).then(function(data) {
                defer.resolve(data.members);
            }, function(message) {
                defer.reject(message);
            });

            return defer.promise;
        };

        service.focus = function(message) {
            Common.focus($messageText, message);
        };

        service.scrollMessages = function() {
            $chatMessages.scrollTo('max');
        };

        return service;
    }]);
})();
