'use strict';

angular.module('worldService', []).factory('World', function(Ws) {
    var service = {};

    var canvas, ctx;

    var sprites = new Image();
    sprites.src = '/img/world/cells.png';

    var hero = new Image();
    hero.src = '/img/world/hero.png';

    service.init = function() {
        canvas = $('canvas#layout');
        ctx    = canvas.get(0).getContext('2d');

        Ws.send({
            controller: 'Layout',
            action: 'getCurrentCell'
        });
    };

    var CELL_WIDTH = 30,
        CELL_HEIGHT = 30,
        CELLS_HORIZONTAL = 9,
        CELLS_VERTICAL = 9,
        HERO_WIDTH = 20,
        HERO_HEIGHT = 20;

    service.drawVicinity = function(vicinity) {
        for (var x = 0; x < CELLS_HORIZONTAL; x++) {
            for (var y = 0; y < CELLS_VERTICAL; y++) {
                if (null === vicinity[x][y]) {
                    ctx.drawImage(sprites,
                                  0,
                                  0,
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

        ctx.drawImage(hero,
                      CELL_WIDTH * Math.floor(CELLS_HORIZONTAL / 2) + (CELL_WIDTH - HERO_WIDTH) / 2,
                      CELL_HEIGHT * Math.floor(CELLS_VERTICAL / 2) + (CELL_HEIGHT - HERO_HEIGHT) / 2,
                      HERO_WIDTH,
                      HERO_HEIGHT);
    };

    return service;
});
