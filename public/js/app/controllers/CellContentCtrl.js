'use strict';

function CellContentCtrl($scope) {
    $scope.selectedItem = undefined;

    $scope.content = {
        npcs: [],
        characters: [],
        mobs: []
    };

    $scope.selectItem = function(type, id) {
        $scope.selectedItem = {
            type: type,
            id: id
        };
    };

    $scope.$on('cell-content', function(e, content) {
        $scope.content = content;

        // foreach'и оказались очень тяжёлыми

        // Удаление старых NPC
        /*angular.forEach($scope.content.npcs, function(item, i) {
            var found = false;

            angular.forEach(content.npcs, function(value) {
                if (value.id === item.id) {
                    found = true;
                }
            });

            if (!found) {
                $scope.content.npcs.splice(i, 1);
            }
        });

        // Удаление старых персонажей
        angular.forEach($scope.content.characters, function(item, i) {
            var found = false;

            angular.forEach(content.characters, function(value) {
                if (value.id === item.id) {
                    found = true;
                }
            });

            if (!found) {
                $scope.content.characters.splice(i, 1);
            }
        });

        // Удаление старых мобов
        angular.forEach($scope.content.mobs, function(item, i) {
            var found = false;

            angular.forEach(content.mobs, function(value) {
                if (value.id === item.id) {
                    found = true;
                }
            });

            if (!found) {
                $scope.content.mobs.splice(i, 1);
            }
        });

        // Добавление новых NPC
        angular.forEach(content.npcs, function(item) {
            var found = false;

            angular.forEach($scope.content.npcs, function(value) {
                if (value.id === item.id) {
                    found = true;
                }
            });

            if (!found) {
                item.type  = 'npc';
                $scope.content.npcs.push(item);
            }
        });

        // Добавление новых персонажей
        angular.forEach(content.characters, function(item) {
            var found = false;

            angular.forEach($scope.content.characters, function(value) {
                if (value.id === item.id) {
                    found = true;
                }
            });

            if (!found) {
                item.type  = 'character';
                $scope.content.characters.push(item);
            }
        });

        // Добавление новых мобов
        angular.forEach(content.mobs, function(item) {
            var found = false;

            angular.forEach($scope.content.mobs, function(value) {
                if (value.id === item.id) {
                    found = true;
                }
            });

            if (!found) {
                item.type  = 'mob';
                $scope.content.mobs.push(item);
            }
        });*/
    });
}

CellContentCtrl.$inject = ['$scope'];
