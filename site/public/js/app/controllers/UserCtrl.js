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
                setUser(user);
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

    $scope.$on('login-success', function(e, user) {
        setUser(user);
    });

    $scope.$on('logout-success', function(e, character) {
        delete($scope.user);
    });

    function setUser(user) {
        $scope.user = user;
        User.showCharactersList()
            .then(function(characters) {
                $scope.user.characters = characters;
            }, function(message) {
                alert(message);
            });
    }
}

UserCtrl.$inject = ['$scope', '$window', 'User'];
