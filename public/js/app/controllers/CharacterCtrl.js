'use strict';

function CharacterCtrl($scope, $window) {
    $scope.character = $window.character;

    $scope.$on('character-chosen', function(e, character) {
        $scope.character = character;
    });

    $scope.$on('logout-result', function(e, result) {
        if (result) {
            delete($scope.character);
        }
    });
}

CharacterCtrl.$inject = ['$scope', '$window'];
