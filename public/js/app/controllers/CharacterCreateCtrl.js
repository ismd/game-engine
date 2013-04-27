'use strict';

function CharacterCreateCtrl($scope, CharacterCreate, Character) {

    $scope.create = function() {
        CharacterCreate.create($scope.newCharacter);
    };

    $scope.$on('characterCreated', function(e, created, message, id) {
        $scope.message = message;

        if (created) {
            Character.setCharacter(id);
        }
    });
}

CharacterCreateCtrl.$inject = ['$scope', 'CharacterCreate', 'Character'];
