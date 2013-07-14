'use strict';

function WorldCtrl($scope, World) {
    $scope.selectedItem = null;

    $scope.cell = {
        idLayout: '...',
        x: '...',
        y: '...',
        content: {
            npcs: [],
            characters: [],
            mobs: []
        }
    };

    $scope.selectItem = function(type, id) {
        $scope.selectedItem = {
            type: type,
            id: id
        };
    };

    $scope.move = function(direction) {
        console.log('Moving ' + direction);
        /*Cell.move(direction).then(function() {

        });*/
    };

    $scope.$on('cell-update', function(e, data) {
        var cell = data.cell;

        $scope.cell.idLayout = cell.idLayout;
        $scope.cell.x = cell.x;
        $scope.cell.y = cell.y;

        World.drawVicinity(cell.vicinity);

        $scope.cell.content.npcs = cell.content.NPC;
        $scope.cell.content.characters = cell.content.CHARACTER;
        $scope.cell.content.mobs = cell.content.MOB;
    });
}

WorldCtrl.$inject = ['$scope', 'World'];
