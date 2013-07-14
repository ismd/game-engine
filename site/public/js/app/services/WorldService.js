'use strict';

angular.module('worldService', []).factory('World', function(Ws, $rootScope, $q) {
    var service = {};

    //var layout = [];

    var canvas = $('canvas#layout');
    var ctx    = canvas.get(0).getContext('2d');

    var sprites = new Image();
    sprites.src = '/img/world/cells.png';

    var player = new Image();
    player.src = '/img/world/hero.png';

    sprites.onload = function() {
        Ws.send({
            controller: 'Layout',
            action: 'getCurrentCell'
        });
    };

    /*service.move = function(direction) {
        var newX = x;
        var newY = y;

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
return;
        Ws.send({
            controller: 'Character',
            action: 'move',
            args: {
                x: newX,
                y: newY
            }
        }).then(function(data) {
            if ('ok' !== data.status) {
                alert(data.message);
                return;
            }

            move(data.x, data.y, data.layout);
        }, function() {

        });

        $http.post('/api/character/move', {
            x: newX,
            y: newY
        }).success(function(data) {
            if ('ok' !== data.status) {
                alert(data.message);
                return;
            }

            move(data.x, data.y, angular.fromJson(data.layout));
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    };*/

    /*function move(data_x, data_y, data_layout) {
        x = data_x;
        y = data_y;
        layout = data_layout;

        drawLayout(layout);

        $rootScope.$broadcast('move', x, y);
    }*/

    var CELL_WIDTH = 50,
        CELL_HEIGHT = 50;

    service.drawVicinity = function(vicinity) {
        for (var x = 0; x < 7; x++) {
            for (var y = 0; y < 5; y++) {
                if (null === vicinity[x][y]) {
                    ctx.drawImage(sprites,
                                  0,
                                  CELL_HEIGHT,
                                  CELL_WIDTH,
                                  CELL_HEIGHT,
                                  x * CELL_WIDTH,
                                  y * CELL_HEIGHT,
                                  CELL_WIDTH,
                                  CELL_HEIGHT);
                    continue;
                }

                ctx.drawImage(sprites,
                              vicinity[x][y]['x'] * CELL_WIDTH,
                              vicinity[x][y]['y'] * CELL_HEIGHT,
                              CELL_WIDTH,
                              CELL_HEIGHT,
                              x * CELL_WIDTH,
                              y * CELL_HEIGHT,
                              CELL_WIDTH,
                              CELL_HEIGHT);
            }
        }

        ctx.drawImage(player, 150, 100, 50, 50);
    }

    return service;
});
