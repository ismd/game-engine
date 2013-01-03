define(['jquery'], function($) {

    /**
     * Текущие координаты
     * Заполняются при инициализации
     */
    var id = null,
        x  = null,
        y  = null;

    /**
     * Инициализируем модуль
     */
    $(document).ready(function() {
        var coordinates = $('input#coordinates');

        // Считываем координаты
        id = parseInt(coordinates.attr('id'));
        x  = parseInt(coordinates.attr('x'));
        y  = parseInt(coordinates.attr('y'));
    });
});
