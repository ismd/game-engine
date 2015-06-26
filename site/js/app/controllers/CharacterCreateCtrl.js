(function() {
    'use strict';

    window.mainModule.controller('CharacterCreateCtrl', ['$scope', 'CharacterCreate', 'Character', function($scope, CharacterCreate, Character) {

        CharacterCreate.focus();

        $scope.create = function() {
            CharacterCreate.create($scope.newCharacter).then(function(character) {
                Character.set(character.id);
            }, function(message) {
                $scope.message = message;
            });
        };
    }]);
})();
