'use strict';

function CharacterCreateCtrl($scope, CharacterCreate, Character) {

    $scope.create = function() {
        CharacterCreate.create($scope.newCharacter).then(function(character) {
            Character.setCharacter(character.id);
        }, function(message) {
            $scope.message = message;
        });
    };
}

CharacterCreateCtrl.$inject = ['$scope', 'CharacterCreate', 'Character'];
