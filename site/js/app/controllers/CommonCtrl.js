(function() {
    'use strict';

    window.mainModule.controller('CommonCtrl', ['$scope', 'Common', function($scope, Common) {

        $scope.redirect = function(url) {
            Common.redirect(url);
        };
    }]);
})();
