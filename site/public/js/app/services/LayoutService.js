'use strict';

angular.module('layoutService', []).factory('Layout', function(Ws, $http, $rootScope) {
    var service = {};

    var idLayout,
        x,
        y;

    var cell_width = 50,
        cell_height = 50;

    var layout = [];

    var canvas = $('canvas#layout');
    var ctx    = canvas.get(0).getContext('2d');

    var sprites = new Image();
    sprites.src = '/img/world/layouts/sprites.png';

    var player = new Image();

    sprites.onload = function() {
        //initLayout();
    };

    service.init = function(init_idLayout, init_x, init_y) {
        idLayout = init_idLayout;
        x        = init_x;
        y        = init_y;
    };

    service.move = function(direction) {
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

        Ws.send({
            controller: 'Character',
            action: 'move',
            args: {
                x: newX,
                y: newY
            }
        }).then(function(data) {
            console.log(data);
        });

        /*$http.post('/api/character/move', {
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
        });*/
    };

    function move(data_x, data_y, data_layout) {
        x = data_x;
        y = data_y;
        layout = data_layout;

        drawLayout(layout);

        $rootScope.$broadcast('move', x, y);
    }

    function drawLayout(layout) {
        angular.forEach(layout, function(column, x) {
            angular.forEach(column, function(cell, y) {
                if (cell) {
                    ctx.drawImage(sprites,
                                  cell[0] * cell_width,
                                  cell[1] * cell_height,
                                  cell_width,
                                  cell_height,
                                  x * cell_width,
                                  y * cell_height,
                                  cell_width,
                                  cell_height);
                }
            });
        });

        ctx.drawImage(player, 150, 100, 50, 50);
    }

    function initLayout() {
        $http.get('/api/layout/vicinity').success(function(data) {
            if ('ok' !== data.status) {
                alert(data.message);
                return;
            }

            player.src = '/img/world/hero.png';

            player.onload = function() {
                drawLayout(angular.fromJson(data.layout));
            };
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    }

    return service;
});
