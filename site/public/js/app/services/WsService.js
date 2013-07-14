'use strict';

angular.module('wsService', []).factory('Ws', function($q, $rootScope, $window) {
    var service = {};

    var callbacks = {};
    var idCurrentCallback = 0;

    var config = $window.ws;
    var ws = new WebSocket('ws://' + config.host + ':' + config.port);

    var opened = false;
    var initialized = false;
    var queue = [];

    ws.onopen = function() {
        opened = true;
        console.log('Socket has been opened!');

        sendQueue();
    };

    ws.onmessage = function(message) {
        listener(angular.fromJson(message.data));
    };

    ws.onerror = function() {
        opened = false;
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
        } else {
            if ('Character' === request.controller && 'set' === request.action) {
                queue.unshift(request);
            } else {
                queue.push(request);
            }
        }

        return defer.promise;
    };

    function wsSend(request) {
        console.log('Sending request: ', request);
        ws.send(JSON.stringify(request));
    }

    function listener(data) {
        console.log('Received response: ', data);

        if (data.broadcast) {
            $rootScope.$broadcast(data.broadcastName, data.data);
        }

        if (callbacks.hasOwnProperty(data.idCallback)) {
            var idCallback = data.idCallback;

            if (data.status) {
                $rootScope.$apply(callbacks[idCallback].cb.resolve(data.data, data.message));

                if (!initialized) {
                    initialized = true;
                    sendQueue();
                }
            } else {
                $rootScope.$apply(callbacks[idCallback].cb.reject(data.data, data.message));
            }

            delete callbacks[idCallback];
        }
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
                if ('Character' === request.controller && 'set' === request.action) {
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

    return service;
});
