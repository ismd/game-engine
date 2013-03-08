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
                CharactersList.showCharactersList();
            } else {
                alert('Не удалось войти');
                loginButton.removeClass('disabled');
            }
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    };

    $scope.$on('showCharactersList', function() {
        var selectCharacterForm = $('div#select-character');

        selectCharacterForm.modal();
        $scope.loadCharacters();
    });

    $scope.loadCharacters = function() {
        var loading = $('div#select-character').find('img.loading');

        $http.get('/api/user/characters').success(function(data) {
            loading.hide();
            $scope.characters = data;
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    }
}

UserCtrl.$inject = ['$scope', '$http', 'CharactersList'];
