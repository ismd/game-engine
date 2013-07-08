'use strict';

function CharacterCtrl($scope, Character, $location) {
    Character.getCharacter().then(function(character) {
        $scope.character = character;
    });

    $scope.setCharacter = function(id) {
        Character.setCharacter(id)
            .then(function(character) {
                $scope.character = character;
                $location.path('/world');
            }, function(message) {
                $scope.setCharacterMessage = message;
            });
    };

    $scope.$on('logout-success', function(e) {
        delete($scope.character);
    });

    $scope.$on('move', function(e, x, y) {
        $scope.character.x = x;
        $scope.character.y = y;
    });
}

CharacterCtrl.$inject = ['$scope', 'Character', '$location'];
