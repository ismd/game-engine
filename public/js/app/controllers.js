function AuthCtrl($scope, $http) {
    var authForm            = $('div#auth-form');
    var selectCharacterForm = $('div#select-character');
    var loginButton         = $('button#login-button');

    $scope.login = function(username, password) {
        loginButton.addClass('disabled');

        $http.post('/api/auth/login', {
            username: username,
            password: password
        }).success(function(data) {
            if ('ok' === data.status) {
                authForm.modal('hide');
                selectCharacterForm.modal();
            } else {
                alert('Не удалось войти');
                loginButton.removeClass('disabled');
            }
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    };
}
