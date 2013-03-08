function UserCtrl($scope, User, Character) {
    $scope.login = function(username, password) {
        User.login(username, password);
    };

    $scope.$on('logged', function(e, user) {
        $scope.user = user;
        User.showCharactersList();
    });

    $scope.$on('characters-list-update', function(e, characters) {
        $scope.characters = characters;
    });

    $scope.setCharacter = function(character) {
        Character.setCharacter(character.id);
    }
}

UserCtrl.$inject = ['$scope', 'User', 'Character'];
