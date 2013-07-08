'use strict';

function RegistrationCtrl($scope, Registration, User, $location) {

    $scope.register = function() {
        Registration.register($scope.user)
            .then(function() {
                $location.path('/');
                User.login($scope.user.login, $scope.user.password);
            }, function(message) {
                $scope.message = message;
            });
    };
}

RegistrationCtrl.$inject = ['$scope', 'Registration', 'User', '$location'];
