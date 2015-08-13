(function() {
    'use strict';

    window.mainModule.factory('LoadManager', ['$q', function($q) {
        var service = {};

        service.load = function loadManager(images) {
            var defer = $q.defer();

            var loadCount = images.length;
            for (var i = 0; i < loadCount; i++) {
                $(images[i]).load(function() {
                    if (0 === --loadCount) {
                        defer.resolve();
                    }
                });
            }

            return defer.promise;
        };

        return service;
    }]);
})();
