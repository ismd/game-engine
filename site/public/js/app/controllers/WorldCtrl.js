'use strict';

function WorldCtrl($scope, World, Ws, Character, Chat) {
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

    $scope.selectItem = function(type, item) {
        $scope.selectedItem = {
            type: type,
            item: item
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

        Character.move($scope.cell.idLayout, newX, newY).then(function() {
            $scope.selectedItem = null;
        });
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

        $scope.$apply();
    });

    $scope.talk = function(item) {
        if (null === item) {
            return;
        }

        if ('npc' === item.type) {
            talkToNpc(item.item);
        } else if ('character' === item.type) {
            talkToCharacter(item.item);
        }
    };

    function talkToNpc(npc) {
        alert(npc.greeting);
    }

    function talkToCharacter(character) {
        Chat.focus(character.name + ', ');
    }
}

WorldCtrl.$inject = ['$scope', 'World', 'Ws', 'Character', 'Chat'];
