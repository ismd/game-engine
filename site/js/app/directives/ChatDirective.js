(function() {
    'use strict';

    window.mainModule.directive('chat', function($window) {
        return function(scope, $element) {
            $window = $($window);

            var offsetTop      = $element.offset().top,
                messagesHeight = 0;

            scope.getWindowHeight = function() {
                return $window.height();
            };

            scope.$watch(scope.getWindowHeight, function(newValue) {
                scope.resize = function() {
                    messagesHeight = newValue - offsetTop - 50;

                    return {
                        height: messagesHeight + 'px'
                    };
                };
            }, true);

            $window.resize(function() {
                scope.$apply();
            });
        };
    });
})();
