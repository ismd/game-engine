(function() {
    'use strict';

    window.mainModule.directive('backgroundImage', function() {
        return function(scope, element, attrs) {
            attrs.$observe('backgroundImage', function(image) {
                element.css({
                    'background-image': 'url(' + image +')'
                });
            });
        };
    });
})();
