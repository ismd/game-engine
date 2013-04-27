'use strict';

function UserCtrl($scope, $window, User, Character) {
    $scope.user = $window.user;

    $scope.login = function(username, password) {
        User.login(username, password);
    };

    $scope.logout = function() {
        User.logout();
    };

    $scope.$on('logged', function(e, logged) {
        if (!logged) {
            delete($scope.user);
            return;
        }

        User.showCharactersList();
    });

    $scope.$on('setUser', function(e, user) {
        $scope.user = user;
    });

    $scope.$on('characters-list-update', function(e, characters) {
        $scope.user.characters = characters;
    });

    $scope.setCharacter = function(id) {
        Character.setCharacter(id);
    };
}

UserCtrl.$inject = ['$scope', '$window', 'User', 'Character'];
