'use strict';

angular.module('chatDirective', []).directive('chat', function($window) {
    return function(scope, element) {
        var window = angular.element($window),
            offsetTop = element.offset().top,
            divHeight,
            table = element.find('table'),
            tableHeight = 0,
            interval;

        scope.getWindowHeight = function() {
            return window.height();
        };

        scope.getTableHeight = function() {
            return table.height();
        };

        scope.$watch(scope.getWindowHeight, function(newValue) {
            scope.windowHeight = newValue;

            scope.resize = function() {
                divHeight = newValue - offsetTop - 50;

                return {
                    height: divHeight + 'px'
                };
            };
        }, true);

        scope.$watch(scope.getTableHeight, function(height) {
            clearInterval(interval);

            interval = setInterval(function() {
                if (tableHeight > height - divHeight + 1) {
                    clearInterval(interval);
                }

                tableHeight++;
                element.scrollTop(tableHeight);
            }, 10);
        }, true);

        window.bind('resize', function() {
            scope.$apply();
        });
    };
});
