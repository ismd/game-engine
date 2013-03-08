/**
 * Модуль для всплывающих окон
 */
var windowServices = angular.module('windowServices', []);

/**
 * Список персонажей пользователя
 */
windowServices.factory('CharactersList', function($rootScope, $http) {
    var selectCharacterForm = $('div#select-character');
    var loading             = selectCharacterForm.find('img.loading');

    return {
        'show': function() {
            selectCharacterForm.modal();

            $http.get('/api/user/characters').success(function(data) {
                loading.hide();
                $rootScope.$broadcast('characters-list-update', data);
            }).error(function() {
                alert('Не удалось обратиться к серверу');
            });
        }
    };
});
