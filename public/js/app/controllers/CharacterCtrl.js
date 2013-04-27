'use strict';

function CharacterCtrl($scope, $window, Character, $location) {
    $scope.character = $window.character;

    $scope.setCharacter = function(id) {
        Character.setCharacter(id);
    };

    $scope.$on('set-character-result', function(e, result, message, character) {
        $scope.setCharacterMessage = message;

        if (result) {
            $scope.character = character;
            $location.path('/world');
        }
    });

    $scope.$on('logout-result', function(e, result) {
        if (result) {
            delete($scope.character);
        }
    });

    $scope.$on('move', function(e, x, y) {
        $scope.character.x = x;
        $scope.character.y = y;
    });
}

CharacterCtrl.$inject = ['$scope', '$window', 'Character', '$location'];
