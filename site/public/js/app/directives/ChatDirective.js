'use strict';

angular.module('chatDirective', []).directive('chat', function($window) {
    return function(scope, element) {
        var window = angular.element($window),
            offsetTop = element.offset().top,
            interval,
            messagesDiv = element.find('div#messages'),
            table = messagesDiv.find('table');

        var messagesHeight = 0,
            tableHeight = 0;

        scope.getWindowHeight = function() {
            return window.height();
        };

        scope.getTableHeight = function() {
            return table.height();
        };

        scope.$watch(scope.getWindowHeight, function(newValue) {
            scope.resize = function() {
                messagesHeight = newValue - offsetTop - 50;

                return {
                    height: messagesHeight + 'px'
                };
            };
        }, true);

        scope.$watch(scope.getTableHeight, function(height) {
            clearInterval(interval);

            if (height <= messagesHeight) {
                return;
            }

            interval = setInterval(function() {
                if (tableHeight >= height - messagesHeight) {
                    clearInterval(interval);
                    return;
                }

                tableHeight++;
                messagesDiv.scrollTop(tableHeight);
            }, 10);
        }, true);

        window.bind('resize', function() {
            scope.$apply();
        });
    };
});
