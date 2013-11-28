'use strict';

function RegistrationCtrl($scope, Registration, User, Common) {

    $scope.register = function() {
        Registration.register($scope.user).then(function() {
            Common.redirect('/');
            User.login($scope.user.login, $scope.user.password);
        }, function(message) {
            $scope.message = message;
        });
    };
}

RegistrationCtrl.$inject = ['$scope', 'Registration', 'User', 'Common'];
