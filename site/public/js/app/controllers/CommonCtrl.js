'use strict';

function CommonCtrl($scope, Common) {

    $scope.redirect = function(url) {
        Common.redirect(url);
    };
}

CommonCtrl.$inject = ['$scope', 'Common'];
