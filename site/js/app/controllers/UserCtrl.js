(function() {
    'use strict';

    window.mainModule.controller('UserCtrl', ['$scope', '$timeout', 'User', 'Common', function($scope, $timeout, User, Common) {
        $scope.user = JSON.parse(localStorage.getItem('user'));

        if (null !== $scope.user) {
            User.loginByAuthKey($scope.user.id, $scope.user.authKey);
        }

        // true, когда происходит процесс авторизации
        $scope.loginInProcess = false;

        $scope.showCharactersList = function() {
            User.showCharactersList().then(function(characters) {
                $scope.user.characters = characters;
            }, function(message) {
                alert(message);
            });
        };

        $scope.login = function(username, password) {
            if ($scope.loginInProcess) {
                return;
            }

            $scope.loginInProcess = true;

            User.login(username, password).then(function() {
                // Обработка в броадкасте login-success
            }, function(message) {
                $scope.loginInProcess = false;
                $scope.loginMessage   = message;
            });
        };

        $scope.logout = function() {
            User.logout().then(function() {
                Common.redirect('/');
            });
        };

        $scope.$on('set-character-success', function(e, data) {
            var character = data.character,
                found = false;

            angular.forEach($scope.user.characters, function(item) {
                if (item.id === character.id) {
                    found = true;
                }
            });

            if (!found) {
                $scope.user.characters.push(character);
            }
        });

        $scope.$on('login-success', function(e, data) {
            $scope.user = data.user;

            User.showCharactersList().then(function(characters) {
                $scope.user.characters = characters;
            }, function(message) {
                alert(message);
            });

            $scope.loginInProcess = false;
        });

        $scope.$on('logout-success', function(e) {
            $scope.user = null;
            localStorage.setItem('user', null);
        });

        $scope.$on('init', function(e, data) {
            $scope.user = data.user;
        });

        $scope.openLoginForm = function() {
            $timeout(function() {
                User.focus();
            }, 500);
        };
    }]);
})();
