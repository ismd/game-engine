(function() {
    'use strict';

    window.mainModule.factory('Events', ['$rootScope', '$document', function($rootScope, $document) {
        var service = {};

        $document.keydown(function(e) {
            switch (e.keyCode) {
                case 38:
                    $rootScope.$broadcast('keydown', 'up');
                    break;

                case 39:
                    $rootScope.$broadcast('keydown', 'right');
                    break;

                case 40:
                    $rootScope.$broadcast('keydown', 'down');
                    break;

                case 37:
                    $rootScope.$broadcast('keydown', 'left');
                    break;
            }
        });

        return service;
    }]);
})();
