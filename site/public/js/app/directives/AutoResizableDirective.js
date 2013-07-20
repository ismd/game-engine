'use strict';

angular.module('autoResizableDirective', []).directive('autoResizable', function($window) {
    return function(scope, element) {
        var window = angular.element($window),
            offsetTop = element.offset().top;

        scope.getWindowHeight = function() {
            return window.height();
        };

        scope.$watch(scope.getWindowHeight, function(newValue) {
            scope.windowHeight = newValue;

            scope.style = function() {
                return {
                    'height': (newValue - offsetTop - 20) + 'px'
                };
            };
        }, true);

        window.bind('resize', function() {
            scope.$apply();
        });
    };
});
