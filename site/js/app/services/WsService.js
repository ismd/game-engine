(function() {
    'use strict';

    window.mainModule.factory('Ws', ['$q', '$rootScope', '$window', 'Common', function($q, $rootScope, $window, Common) {
        var service = {};

        var callbacks = {},
            idCurrentCallback = 0;

        var config = $window.ws,
            ws = new WebSocket('ws://' + config.host + ':' + config.port);

        var opened = false,
            initialized = false,
            queue = [];

        ws.onopen = function() {
            opened = true;
            console.log('Успешно подключились к серверу');

            sendQueue();
        };

        ws.onmessage = function(message) {
            var data = angular.fromJson(message.data);
            console.log('Received response:', data);

            if (callbacks.hasOwnProperty(data.idCallback)) {
                var idCallback = data.idCallback;

                if (data.status) {
                    if (!initialized) {
                        initialized = true;
                        $rootScope.$apply(callbacks[idCallback].cb.resolve(data.data));
                        sendQueue();
                    } else {
                        $rootScope.$apply(callbacks[idCallback].cb.resolve(data.data));
                    }
                } else {
                    $rootScope.$apply(callbacks[idCallback].cb.reject(data.message));
                }

                if (data.broadcast) {
                    $rootScope.$broadcast(data.broadcastName, data.data);
                }

                delete callbacks[idCallback];
            } else if (data.broadcast) {
                $rootScope.$broadcast(data.broadcastName, data.data);
            }
        };

        ws.onerror = function() {
            opened = false;
            initialized = false;
            queue = [];
            alert('Не удалось подключиться к серверу');
        };

        service.send = function(request) {
            var defer = $q.defer();
            var idCallback = getIdCallback();

            callbacks[idCallback] = {
                time: new Date(),
                cb: defer
            };

            request.idCallback = idCallback;

            if (opened && initialized) {
                wsSend(request);
            } else if (opened &&
                       (('User' === request.controller && 'login' === request.action) ||
                        ('User' === request.controller && 'register' === request.action) ||
                        'User' === request.controller && 'loginByAuthKey' === request.action)) {
                wsSend(request);
            } else if (('User' === request.controller && 'login' === request.action) ||
                       ('User' === request.controller && 'loginByAuthKey' === request.action)) {
                console.log('Pushing at the beginning of queue', request);
                queue.unshift(request);
            } else {
                console.log('Pushing at the end of queue', request);
                queue.push(request);
            }

            return defer.promise;
        };

        function wsSend(request) {
            console.log('Sending request: ', request);
            ws.send(JSON.stringify(request));
        }

        function getIdCallback() {
            idCurrentCallback++;

            if (idCurrentCallback > 10000) {
                idCurrentCallback = 0;
            }

            return idCurrentCallback;
        }

        function sendQueue() {
            if (!initialized) {
                for (var i = 0; i < queue.length; i++) {
                    var request = queue[i];

                    if ('User' === request.controller && 'loginByAuthKey' === request.action) {
                        wsSend(request);
                        queue.splice(i, 1);
                        return;
                    }
                }

                return;
            }

            while (queue.length > 0) {
                wsSend(queue.shift());
            }
        }

        $rootScope.$on('logout-success', function(e) {
            queue = [];
            Common.redirect('/');
        });

        return service;
    }]);
})();
