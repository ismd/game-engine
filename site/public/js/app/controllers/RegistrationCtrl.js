'use strict';

function RegistrationCtrl($scope, Registration, User, $location) {

    $scope.register = function() {
        Registration.register($scope.user);
    };

    $scope.$on('registered', function(e, registered, message) {
        $scope.message = message;

        if (registered) {
            $location.path('/');
            User.login($scope.user.login, $scope.user.password);
        }
    });
}

RegistrationCtrl.$inject = ['$scope', 'Registration', 'User', '$location'];
