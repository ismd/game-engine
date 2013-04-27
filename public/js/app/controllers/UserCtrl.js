'use strict';

function UserCtrl($scope, $window, User) {
    $scope.user = $window.user;

    // true, когда происходит процесс авторизации
    $scope.loginInProcess = false;

    $scope.login = function(username, password) {
        if ($scope.loginInProcess) {
            return;
        }

        $scope.loginInProcess = true;
        User.login(username, password);
    };

    $scope.logout = function() {
        User.logout();
    };

    $scope.$on('login-result', function(e, result, message) {
        $scope.loginInProcess = false;
        $scope.loginMessage   = message;

        if (result) {
            User.showCharactersList();
        }
    });

    $scope.$on('logout-result', function(e, result) {
        if (result) {
            delete($scope.user);
        }
    });

    $scope.$on('set-user', function(e, user) {
        $scope.user = user;
    });

    $scope.$on('characters-list-update', function(e, characters) {
        $scope.user.characters = characters;
    });

    $scope.$on('set-character-result', function(e, result, message, character) {
        if (!result) {
            return;
        }

        var found = false;

        angular.forEach($scope.user.characters, function(value, key) {
            if (value.id === character.id) {
                found = true;
            }
        });

        if (!found) {
            $scope.user.characters.push(character);
        }
    });
}

UserCtrl.$inject = ['$scope', '$window', 'User'];
