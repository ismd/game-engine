(function() {
    'use strict';

    window.mainModule.factory('Character', ['$q', 'Ws', function($q, Ws) {
        var service = {};

        var $selectCharacterPopup = $('.js-select-character-popup');

        service.set = function(id) {
            var defer = $q.defer();

            Ws.send({
                controller: 'Character',
                action: 'set',
                args: {
                    id: id
                }
            }).then(function(data) {
                $selectCharacterPopup.modal('hide');

                localStorage.setItem('character', JSON.stringify(data.character));
                defer.resolve(data.character);
            }, function(message) {
                defer.reject(message);
            });

            return defer.promise;
        };

        service.move = function(idLayout, x, y) {
            var defer = $q.defer();

            Ws.send({
                controller: 'Character',
                action: 'move',
                args: {
                    idLayout: idLayout,
                    x: x,
                    y: y
                }
            }).then(function(data) {
                defer.resolve(data.cell);
            }, function(message) {
                defer.reject(message);
            });

            return defer.promise;
        };

        return service;
    }]);
})();
