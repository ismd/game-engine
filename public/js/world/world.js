/**
 * Карта
 *
 * @author ismd
 */

var Map = {
    // Текущие координаты. Заполняются при инициализации
    id: null,
    x: null,
    y: null,

    /**
     * Перемещение
     *
     * @param dx Перемещение влево или вправо (-1, 1)
     * @param dy Перемещение вверх или вниз (-1, 1)
     */
    move: function(dx, dy) {
        var newX = Map.x + dx;
        var newY = Map.y + dy;

        $.ajax({
            url: '/character/move',
            type: 'post',
            data: {
                'x': newX,
                'y': newY
            },
            async: false
        }).done(function(data) {
            switch (data) {
                case 'ok':
                    break;
                
                case 'error: fast moving':
                    alert('Слишком быстрое перемещение');
                    return;
                    break;
                
                case 'error: cannot move here':
                    alert('Невозможно переместиться на заданную клетку');
                    return;
                    break;
                
                default:
                    alert('Ошибка при перемещении');
                    return;
                    break;
            }

            Map.x = newX;
            Map.y = newY;

            CellContent.clear();
            Map.moveMap(dx, dy);
            CellContent.init();
            Map.updateImage();

            $('div#world div#map').attr('x', Map.x);
            $('div#world div#map').attr('y', Map.y);
        });
    },

    /**
     * Динамичное перемещение карты
     *
     * @param dx Перемещение влево или вправо (-1, 1)
     * @param dy Перемещение вверх или вниз (-1, 1)
     */
    moveMap: function(dx, dy) {
        if (dx == -1) {
            $('div#map').css(
                'background-position', '0 -30px'
            );
        } else if (dx == 1) {
            $('div#map').css(
                'background-position', '-60px -30px'
            );
        } else if (dy == -1) {
            $('div#map').css(
                'background-position', '-30px 0px'
            );
        } else if (dy == 1) {
            $('div#map').css(
                'background-position', '-30px -60px'
            );
        }
    },

    /**
     * Обновление изображения карты
     */
    updateImage: function() {
        $('div#map').css({
            'background-image': 'url(/images/world/maps/'
                + Map.id + '/' + Map.x + 'x' + Map.y + '.png)'
        });

        var dx = '-30';
        var dy = '-30';

        if (Map.x < 4) {
            dx = '0';

            Character.setCoordinates(Map.x, Map.y);
        }

        if (Map.y < 4) {
            dy = '0';

            Character.setCoordinates(Map.x, Map.y);
        }

        $('div#map').css(
            'background-position', dx + 'px ' + dy + 'px'
        );
    }
};

/**
 * Персонаж на карте
 */
var Character = {
    marginLeft: 90,
    marginTop: 90,

    /**
     * Устанавливает начальные координаты относительно левого верхнего края карты
     * Необходимо, когда персонаж находится у краёв карты
     *
     * @param x
     * @param y
     */
    setCoordinates: function(x, y) {
        if (x > 3) {
            Character.marginLeft = 90;
        } else {
            Character.marginLeft = x * 30;
        }

        if (y > 3) {
            Character.marginTop = 90;
        } else {
            Character.marginTop = y * 30;
        }

        $('div#world div#map img#character').css('margin-left', Character.marginLeft);
        $('div#world div#map img#character').css('margin-top', Character.marginTop);
    }
};

/**
 * Содержимое клетки
 */
var CellContent = {
    npcs: {},
    characters: {},
    mobs: {},
    interval: null,

    /**
     * Запускает интервал загрузки содержимого клетки
     */
    init: function() {
        CellContent.load();
        CellContent.interval = setInterval(CellContent.load, 2000);
    },

    /**
     * Загружает содержимое клетки
     */
    load: function() {
        $.getJSON('/map/cell', function(data) {
            $.each(data.npcs, function(i, npc) {
                CellContent.appendNpc(npc);
            })

            $.each(data.characters, function(i, character) {
                CellContent.appendCharacter(character);
            })

            $.each(data.mobs, function(i, mob) {
                CellContent.appendMob(mob);
            })
        });
    },

    /**
     * Сбрасывает интервал, чистит содержимое клетки
     */
    clear: function() {
        clearInterval(CellContent.interval);

        CellContent.npcs       = {};
        CellContent.characters = {};
        CellContent.mobs       = {};

        $('div#cell-content').text('');
    },

    /**
     * Добавляет npc в содержимое клетки
     */
    appendNpc: function(npc) {
        if (CellContent.npcs[npc.id] != null) {
            return;
        }

        CellContent.npcs[npc.id] = npc;
        $('div#cell-content').append('Npc: <img src="/images/world/npcs/'
            + npc.image + '" />' + npc.name + '<br />');
    },

    /**
     * Добавляет персонажа в содержимое клетки
     */
    appendCharacter: function(character) {
        if (CellContent.characters[character.id] != null) {
            return;
        }

        CellContent.characters[character.id] = character;
        $('div#cell-content').append('Персонаж: <img src="/images/world/characters/'
            + character.image + '" />' + character.name + '<br />');
    },

    /**
     * Добавляет моба в содержимое клетки
     */
    appendMob: function(mob) {
        if (CellContent.mobs[mob.id] != null) {
            return;
        }

        CellContent.mobs[mob.id] = mob;
        $('div#cell-content').append('Моб: <img src="/images/world/mobs/'
            + mob.image + '" />' + mob.name + '<br />');
    }
};

$(document).ready(function() {
    var map = $('div#world div#map');
    
    Map.id = parseInt(map.attr('idMap'));
    Map.x  = parseInt(map.attr('x'));
    Map.y  = parseInt(map.attr('y'));

    Map.updateImage();

    CellContent.init();
});
