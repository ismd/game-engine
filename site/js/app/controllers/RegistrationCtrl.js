(function() {
    'use strict';

    window.mainModule.controller('RegistrationCtrl', ['$scope', 'Registration', 'User', 'Common', function($scope, Registration, User, Common) {
        $scope.user = {};

        Registration.focus();

        $scope.register = function() {
            Registration.register($scope.user).then(function() {
                Common.redirect('/');
                User.login($scope.user.login, $scope.user.password);
            }, function(message) {
                $scope.message = message;
            });
        };
    }]);
})();
