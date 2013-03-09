function UserCtrl($scope, $window, User, Character) {
    $scope.user = $window.user;

    $scope.login = function(username, password) {
        User.login(username, password);
    };

    $scope.$on('logged', function(e, logged) {
        if (true === logged) {
            User.showCharactersList();
        }
    });

    $scope.$on('setUser', function(e, user) {
        $scope.user = user;
    });

    $scope.$on('characters-list-update', function(e, characters) {
        $scope.characters = characters;
    });

    $scope.setCharacter = function(character) {
        Character.setCharacter(character.id);
    };
}

UserCtrl.$inject = ['$scope', '$window', 'User', 'Character'];
