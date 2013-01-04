define(['jquery'], function($) {

    /**
     * Текущие координаты
     * Заполняются при инициализации
     */
    var id = null,
        x  = null,
        y  = null;

    /**
     * Canvas
     */
    var canvas = null;
    var ctx    = null;

    /**
     * Инициализируем модуль
     */
    $(document).ready(function() {
        var coordinates = $('input#coordinates');

        // Если мы находимся на другой странице
        if (coordinates.length == 0) {
            return;
        }

        // Считываем координаты
        id = parseInt(coordinates.attr('id-map'));
        x  = parseInt(coordinates.attr('x'));
        y  = parseInt(coordinates.attr('y'));

        // Canvas
        canvas = $('canvas#map');
        ctx    = canvas.get(0).getContext('2d');

        // Test data
        ctx.strokeRect(0, 0, 50, 50);
        ctx.strokeRect(50, 0, 50, 50);
        ctx.strokeRect(100, 0, 50, 50);
        ctx.strokeRect(150, 0, 50, 50);
        ctx.strokeRect(200, 0, 50, 50);
        ctx.strokeRect(250, 0, 50, 50);
        ctx.strokeRect(300, 0, 50, 50);
        ctx.strokeRect(0, 50, 50, 50);
        ctx.strokeRect(50, 50, 50, 50);
        ctx.strokeRect(100, 50, 50, 50);
        ctx.strokeRect(150, 50, 50, 50);
        ctx.strokeRect(200, 50, 50, 50);
        ctx.strokeRect(250, 50, 50, 50);
        ctx.strokeRect(300, 50, 50, 50);
        ctx.strokeRect(0, 100, 50, 50);
        ctx.strokeRect(50, 100, 50, 50);
        ctx.strokeRect(100, 100, 50, 50);
        ctx.strokeRect(150, 100, 50, 50);
        ctx.strokeRect(200, 100, 50, 50);
        ctx.strokeRect(250, 100, 50, 50);
        ctx.strokeRect(300, 100, 50, 50);
        ctx.strokeRect(0, 150, 50, 50);
        ctx.strokeRect(50, 150, 50, 50);
        ctx.strokeRect(100, 150, 50, 50);
        ctx.strokeRect(150, 150, 50, 50);
        ctx.strokeRect(200, 150, 50, 50);
        ctx.strokeRect(250, 150, 50, 50);
        ctx.strokeRect(300, 150, 50, 50);
        ctx.strokeRect(0, 200, 50, 50);
        ctx.strokeRect(50, 200, 50, 50);
        ctx.strokeRect(100, 200, 50, 50);
        ctx.strokeRect(150, 200, 50, 50);
        ctx.strokeRect(200, 200, 50, 50);
        ctx.strokeRect(250, 200, 50, 50);
        ctx.strokeRect(300, 200, 50, 50);
    });
});
