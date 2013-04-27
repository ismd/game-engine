'use strict';

function CharacterCtrl($scope, $window) {
    $scope.character = $window.character;

    $scope.$on('characterChosen', function(e, character) {
        $scope.character = character;
    });

    $scope.$on('logged', function(e, logged) {
        if (!logged) {
            delete($scope.character);
        }
    });
}

CharacterCtrl.$inject = ['$scope', '$window'];
