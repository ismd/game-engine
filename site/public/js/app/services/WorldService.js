'use strict';

angular.module('worldService', []).factory('World', function(Ws) {
    var service = {};

    var canvas, ctx;

    var sprites = new Image();
    sprites.src = '/img/world/cells.png';

    var player = new Image();
    player.src = '/img/world/hero.png';

    service.init = function() {
        canvas = $('canvas#layout');
        ctx    = canvas.get(0).getContext('2d');

        Ws.send({
            controller: 'Layout',
            action: 'getCurrentCell'
        });
    };

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
    };

    return service;
});
