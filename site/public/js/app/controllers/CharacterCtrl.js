'use strict';

function CharacterCtrl($scope, Character, Redirector) {
    Character.getCharacter().then(function(character) {
        $scope.character = character;
    });

    $scope.setCharacter = function(id) {
        Character.setCharacter(id)
            .then(function(character) {
                $scope.character = character;
                Redirector.redirect('/world');
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

    $scope.$on('set-character-success', function(e, character) {
        $scope.character = character;
        Redirector.redirect('/world');
    });
}

CharacterCtrl.$inject = ['$scope', 'Character', 'Redirector'];
