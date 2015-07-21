(function() {
    'use strict';

    app.models.Ws = Backbone.Model.extend({

        _callbacks: {},
        _idCurrentCallback: 0,
        _opened: false,
        _initialized: false,
        _queue: [],

        initialize: function() {
            this._ws = new WebSocket('ws://' + window.ws.host + ':' + window.ws.port);

            var self = this;
            this._ws.onopen = function() {
                self._opened = true;
                console.log('Успешно подключились к серверу');

                self._sendQueue();
            };

            this._ws.onerror = function() {
                self._opened = false;
                self._initialized = false;
                self._queue = [];
                alert('Не удалось подключиться к серверу');
            };

            this._ws.onmessage = function(message) {
                var data = JSON.parse(message.data);
                console.log('Received response:', data);

                if (self._callbacks.hasOwnProperty(data.idCallback)) {
                    var idCallback = data.idCallback;

                    if (data.status) {
                        if (!self._initialized) {
                            self._initialized = true;
                            self._callbacks[idCallback].cb.resolve(data.data);
                            self._sendQueue();
                        } else {
                            self._callbacks[idCallback].cb.resolve(data.data);
                        }
                    } else {
                        self._callbacks[idCallback].cb.reject(data.message);
                    }

                    if (data.broadcast) {
                        //$rootScope.$broadcast(data.broadcastName, data.data);
                    }

                    delete self._callbacks[idCallback];
                } else if (data.broadcast) {
                    //$rootScope.$broadcast(data.broadcastName, data.data);
                }
            };
        },

        send: function(request) {
            var defer = Q.defer(),
                idCallback = this._getIdCallback();

            this._callbacks[idCallback] = {
                time: new Date(),
                cb: defer
            };

            request.idCallback = idCallback;

            if (this._opened && this._initialized) {
                this._wsSend(request);
            } else if (this._opened &&
                       (('User' === request.controller && 'login' === request.action) ||
                        // ('User' === request.controller && 'register' === request.action) ||
                        'User' === request.controller && 'loginByAuthKey' === request.action)) {
                this._wsSend(request);
            } else if (('User' === request.controller && 'login' === request.action) ||
                       ('User' === request.controller && 'loginByAuthKey' === request.action)) {
                console.log('Pushing at the beginning of queue', request);
                this._queue.unshift(request);
            } else {
                console.log('Pushing at the end of queue', request);
                this._queue.push(request);
            }

            return defer.promise;
        },

        _wsSend: function(request) {
            console.log('Sending request: ', request);
            this._ws.send(JSON.stringify(request));
        },

        _getIdCallback: function() {
            this._idCurrentCallback++;

            if (this._idCurrentCallback > 10000) {
                this._idCurrentCallback = 0;
            }

            return this._idCurrentCallback;
        },

        _sendQueue: function() {
            if (!this._initialized) {
                for (var i = 0; i < this._queue.length; i++) {
                    var request = this._queue[i];

                    if ('User' === request.controller && 'loginByAuthKey' === request.action) {
                        this._wsSend(request);
                        this._queue.splice(i, 1);
                        return;
                    }
                }

                return;
            }

            while (this._queue.length > 0) {
                this._wsSend(this._queue.shift());
            }
        }
    });
})();
