function AuthCtrl($scope, $http, CharacterList) {
    var authForm    = $('div#auth-form');
    var loginButton = $('button#login-button');

    $scope.login = function(username, password) {
        loginButton.addClass('disabled');

        $http.post('/api/auth/login', {
            username: username,
            password: password
        }).success(function(data) {
            if ('ok' === data.status) {
                authForm.modal('hide');
                CharacterList.showCharactersList();
            } else {
                alert('Не удалось войти');
                loginButton.removeClass('disabled');
            }
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    };
}

AuthCtrl.$inject = ['$scope', '$http', 'CharacterList'];
