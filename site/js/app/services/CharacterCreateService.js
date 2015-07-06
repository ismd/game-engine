(function() {
    'use strict';

    window.mainModule.factory('CharacterCreate', ['$q', 'Ws', 'Common', function($q, Ws, Common) {
        var service = {};

        service.create = function(character) {
            var defer = $q.defer();

            Ws.send({
                controller: 'Character',
                action: 'create',
                args: {
                    name: character.name,
                    image: character.image,
                    biography: character.biography,
                    stat1: character.stats[0],
                    stat2: character.stats[1],
                    stat3: character.stats[2]
                }
            }).then(function(data) {
                defer.resolve(data.character);
            }, function(message) {
                defer.reject(message);
            });

            return defer.promise;
        };

        service.focus = function() {
            Common.focus($('input#name'));
        };

        return service;
    }]);
})();
