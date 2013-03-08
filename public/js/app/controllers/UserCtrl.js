function UserCtrl($scope, $http, CharactersList) {
    $scope.login = function(username, password) {
        var authForm    = $('div#auth-form');
        var loginButton = $('button#login-button');

        loginButton.addClass('disabled');

        $http.post('/api/auth/login', {
            username: username,
            password: password
        }).success(function(data) {
            if ('ok' === data.status) {
                delete data.status;
                $scope.user = data;

                authForm.modal('hide');
                CharactersList.show();
            } else {
                alert('Не удалось войти');
                loginButton.removeClass('disabled');
            }
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    };

    $scope.$on('characters-list-update', function(e, characters) {
        $scope.characters = characters;
    });
}

UserCtrl.$inject = ['$scope', '$http', 'CharactersList'];
