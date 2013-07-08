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
        User.login(username, password)
            .then(function(user) {
                $scope.loginInProcess = false;
                $scope.user = user;
                User.showCharactersList()
                    .then(function(characters) {
                        $scope.user.characters = characters;
                    }, function(message) {
                        alert(message);
                    });
            }, function(message) {
                $scope.loginInProcess = false;
                $scope.loginMessage   = message;
            });
    };

    $scope.logout = function() {
        User.logout().then(function() {
            delete($scope.user);
        });
    };

    $scope.$on('set-character-success', function(e, character) {
        var found = false;

        angular.forEach($scope.user.characters, function(item) {
            if (item.id === character.id) {
                found = true;
            }
        });

        if (!found) {
            $scope.user.characters.push(character);
        }
    });
}

UserCtrl.$inject = ['$scope', '$window', 'User'];
