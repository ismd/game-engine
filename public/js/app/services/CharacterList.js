/**
 * Модуль для всплывающих окон
 */
var windowServices = angular.module('windowServices', []);

/**
 * Список персонажей пользователя
 */
windowServices.factory('CharacterList', function($rootScope) {
    return {
        'showCharactersList': function() {
            $rootScope.$broadcast('showCharactersList');
        }
    };
});
