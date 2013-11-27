'use strict';

function CharacterCtrl($scope, Character, Redirector) {
    $scope.character = null;

    $scope.setCharacter = function(id) {
        Character.setCharacter(id).then(function() {
            // Обработка при броадкасте set-character-success
        }, function(message) {
            $scope.setCharacterMessage = message;
        });
    };

    $scope.$on('set-character-success', function(e, data) {
        $scope.character = data.character;
        Redirector.redirect('/world');
        $scope.$apply();
    });

    $scope.$on('logout-success', function(e) {
        delete($scope.character);
    });

    $scope.$on('move', function(e, x, y) {
        $scope.character.x = x;
        $scope.character.y = y;
    });

    $scope.redirectToCharacterCreate = function() {
        Redirector.redirect('/character/create');
    };
}

CharacterCtrl.$inject = ['$scope', 'Character', 'Redirector'];
