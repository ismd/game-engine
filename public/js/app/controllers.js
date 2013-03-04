function AuthCtrl($scope, $http, Auth) {
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
                Auth.setLogged(true);

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

AuthCtrl.$inject = ['$scope', '$http', 'Auth'];

function CharactersCtrl($scope, $http) {
    var loading = $('div#select-character img.loading');

    $scope.$on('logged', function() {
        $scope.loadCharacters();
    });

    $scope.loadCharacters = function() {
        $http.get('/api/user/characters').success(function(data) {
            loading.hide();
            $scope.characters = data;
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    }
}

CharactersCtrl.$inject = ['$scope', '$http'];
