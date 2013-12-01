'use strict';

angular.module('enterDirective', []).directive('enter', function() {
    return function(scope, element, attrs) {
        element.bind('keydown keypress', function(event) {
            if (13 === event.which) {
                scope.$apply(function() {
                    scope.$eval(attrs.enter);
                });

                event.preventDefault();
            }
        });
    };
});
