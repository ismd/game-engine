/**
 * Модуль для всплывающих окон
 */
var windowServices = angular.module('windowServices', []);

/**
 * Список персонажей пользователя
 */
windowServices.factory('CharactersList', function($rootScope) {
    return {
        'showCharactersList': function() {
            $rootScope.$broadcast('showCharactersList');
        }
    };
});
