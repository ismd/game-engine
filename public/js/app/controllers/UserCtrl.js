function UserCtrl($scope, User) {
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
}

UserCtrl.$inject = ['$scope', 'User'];
