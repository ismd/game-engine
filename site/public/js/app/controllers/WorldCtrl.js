'use strict';

function WorldCtrl($scope, World, Ws, Character) {
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

    World.init();

    $scope.selectItem = function(type, id) {
        $scope.selectedItem = {
            type: type,
            id: id
        };
    };

    $scope.move = function(direction) {
        var newX = $scope.cell.x;
        var newY = $scope.cell.y;

        switch (direction) {
            case 'top':
                newY--;
                break;

            case 'right':
                newX++;
                break;

            case 'bottom':
                newY++;
                break;

            case 'left':
                newX--;
                break;
        }

        Ws.send({
            controller: 'Character',
            action: 'move',
            args: {
                idLayout: $scope.cell.idLayout,
                x: newX,
                y: newY
            }
        }).then(function(data) {

        });
    };

    var idCharacter;
    Character.getCharacter().then(function(character) {
        idCharacter = character.id;
    });

    $scope.$on('cell-update', function(e, data) {
        var cell = data.cell;

        $scope.cell.idLayout = cell.idLayout;
        $scope.cell.x = cell.x;
        $scope.cell.y = cell.y;

        World.drawVicinity(cell.vicinity);

        for (var i = 0; i < cell.content.CHARACTER.length; i++) {
            if (idCharacter === cell.content.CHARACTER[i].id) {
                cell.content.CHARACTER.splice(i, 1);
                break;
            }
        }

        $scope.cell.content.npcs = cell.content.NPC;
        $scope.cell.content.characters = cell.content.CHARACTER;
        $scope.cell.content.mobs = cell.content.MOB;
    });
}

WorldCtrl.$inject = ['$scope', 'World', 'Ws', 'Character'];
