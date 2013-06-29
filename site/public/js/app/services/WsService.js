'use strict';

angular.module('wsService', []).factory('Ws', function($q, $rootScope, $window) {
    var service = {};

    var callbacks = {};
    var idCurrentCallback = 0;

    var config = $window.ws;
    var ws = new WebSocket('ws://' + config.host + ':' + config.port);

    ws.onopen = function() {
        console.log('Socket has been opened!');
    };

    ws.onmessage = function(message) {
        listener(angular.fromJson(message.data));
    };

    ws.onerror = function() {
        alert('Не удалось подключиться к серверу');
    };

    service.sendRequest = function(request) {
        var defer = $q.defer();
        var idCallback = getIdCallback();

        callbacks[idCallback] = {
            time: new Date(),
            cb: defer
        };

        request.idCallback = idCallback;
        console.log('Sending request', request);
        ws.send(JSON.stringify(request));

        return defer.promise;
    };

    function listener(data) {
        console.log('Received data from websocket: ', messageObj);

        if (callbacks.hasOwnProperty(data.idCallback)) {
            var idCallback = data.idCallback;

            delete data.idCallback;

            $rootScope.$apply(callbacks[idCallback].cb.resolve(data));
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

    return service;
});
