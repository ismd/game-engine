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

        if (!$scope.selectedItem) {
            return;
        }

        // Если на клетке уже нет выбранного item'а, то очищаем selectedItem
        var found = false;
        var id    = $scope.selectedItem.id;

        switch ($scope.selectedItem.type) {
            case 'npc':
                angular.forEach(content.npcs, function(item) {
                    if (id === item.id) {
                        found = true;
                    }
                });
                break;

            case 'character':
                angular.forEach(content.characters, function(item) {
                    if (id === item.id) {
                        found = true;
                    }
                });
                break;

            case 'mob':
                angular.forEach(content.mobs, function(item) {
                    if (id === item.id) {
                        found = true;
                    }
                });
                break;
        }

        if (!found) {
            $scope.selectedItem = undefined;
        }
    });
}

CellContentCtrl.$inject = ['$scope'];
