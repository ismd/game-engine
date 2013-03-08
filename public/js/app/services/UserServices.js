var userServices = angular.module('userServices', []);

/**
 * Список персонажей пользователя
 */
userServices.factory('User', function($rootScope, $http) {
    return {
        'login': function(username, password) {
            var authForm    = $('div#auth-form');
            var loginButton = $('button#login-button');

            loginButton.addClass('disabled');

            $http.post('/api/auth/login', {
                username: username,
                password: password
            }).success(function(data) {
                if ('ok' === data.status) {
                    delete data.status;
                    $rootScope.$broadcast('logged', data);

                    authForm.modal('hide');
                } else {
                    alert('Не удалось войти');
                    loginButton.removeClass('disabled');
                }
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        },
        'showCharactersList': function() {
            var selectCharacterForm = $('div#select-character');

            selectCharacterForm.modal();

            $http.get('/api/user/characters').success(function(data) {
                var loading = selectCharacterForm.find('img.loading');

                loading.hide();
                $rootScope.$broadcast('characters-list-update', data);
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        }
    };
});
