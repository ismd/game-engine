'use strict';

function CharacterCtrl($scope, Character, Common) {
    $scope.character = null;

    $scope.setCharacter = function(id) {
        Character.set(id).then(function() {
            // Обработка при броадкасте set-character-success
        }, function(message) {
            $scope.setCharacterMessage = message;
        });
    };

    $scope.$on('set-character-success', function(e, data) {
        $scope.character = data.character;
        Common.redirect('/world');
        $scope.$apply();
    });

    $scope.$on('logout-success', function(e) {
        $scope.character = null;
        localStorage.setItem('character', null);
    });

    $scope.$on('move', function(e, x, y) {
        $scope.character.x = x;
        $scope.character.y = y;
    });

    $scope.$on('init', function(e, data) {
        $scope.character = data.character;
        $scope.$apply();
    });
}

CharacterCtrl.$inject = ['$scope', 'Character', 'Common'];
