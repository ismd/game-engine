(function() {
    'use strict';

    window.mainModule.factory('World', ['$q', 'Ws', 'Common',
                                        function($q, Ws, Common) {
        var service = {};

        var ctx         = null,
            cellsSprite = new Image,
            hero        = new Image,
            initialized = false,
            needDraw    = undefined;

        loadManager([cellsSprite, hero]).then(function() {
            initialized = true;

            if ('undefined' !== typeof needDraw) {
                service.drawVicinity(needDraw);
            }
        });

        cellsSprite.src = '/img/world/cells.png';
        hero.src        = '/img/world/hero.png';

        service.init = function() {
            ctx = $('.js-map').get(0).getContext('2d');

            Ws.send({
                controller: 'Layout',
                action: 'getCurrentCell'
            });
        };

        var CELL_WIDTH       = 30,
            CELL_HEIGHT      = 30,
            CELLS_HORIZONTAL = 9,
            CELLS_VERTICAL   = 9,
            HERO_WIDTH       = 20,
            HERO_HEIGHT      = 20;

        service.drawVicinity = function(vicinity) {
            if (!initialized) {
                needDraw = vicinity;
                return;
            }

            for (var x = 0; x < CELLS_HORIZONTAL; x++) {
                for (var y = 0; y < CELLS_VERTICAL; y++) {
                    if (null === vicinity[x][y]) {
                        ctx.drawImage(cellsSprite,
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

                    ctx.drawImage(cellsSprite,
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

            drawHero();

            function drawHero() {
                ctx.drawImage(hero,
                              CELL_WIDTH * Math.floor(CELLS_HORIZONTAL / 2) + (CELL_WIDTH - HERO_WIDTH) / 2,
                              CELL_HEIGHT * Math.floor(CELLS_VERTICAL / 2) + (CELL_HEIGHT - HERO_HEIGHT) / 2,
                              HERO_WIDTH,
                              HERO_HEIGHT);
            }
        };

        service.focus = function() {
            Common.focus($('.js-message-text'));
        };

        function loadManager(images) {
            var defer = $q.defer();

            var loadCount = images.length;
            for (var i = 0; i < loadCount; i++) {
                $(images[i]).load(function() {
                    if (0 === --loadCount) {
                        defer.resolve();
                    }
                });
            }

            return defer.promise;
        }

        return service;
    }]);
})();
