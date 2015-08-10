(function() {
    'use strict';

    app.views.Map = app.views.Map || {};

    app.views.Map.Index = Backbone.View.extend({

        map: undefined,

        initialize: function() {
            this.map = new app.views.CanvasMap({
                el: this.$el.find('.js-map')
            });

            this.map.on('cellsUpdated', function(cells) {
                $('.js-text').val(JSON.stringify(cells));
            });
        },

        events: {
            'submit .js-map-size': function(e, el) {
                e.preventDefault();

                var $mapSize = $('.js-map-size'),
                    width = $mapSize.find('input[name="width"]').val(),
                    height = $mapSize.find('input[name="height"]').val();

                this.map.setSize(width, height);
            },

            'click .js-download-map': function() {
                this.map.fillCells([]);

                var $downloadMap = $('.js-download-map');
                $downloadMap.attr('href', this.map.getDataUrl());
                $downloadMap.attr('download', 'map.png');
            },

            'click .js-tile': function(e) {
                var cells = this.map.getFilledCells(),
                    $target = $(e.target);

                if (0 === cells.length) {
                    alert('Не выбрана клетка');
                    return;
                }

                var coords = [$target.data('x'), $target.data('y')];

                for (var i = 0; i < cells.length; i++) {
                    var cell = cells[i];
                    this.map.setCell(cell.x, cell.y, coords);
                }

                this.map.fillCells([]);
            },

            'click .js-copy-map': function() {
                $('.js-text').select();

                try {
                    var successful = document.execCommand('copy');

                    if (!successful) {
                        alert('Не удалось скопировать в буфер обмена');
                    }
                } catch (err) {
                    alert('Не удалось скопировать в буфер обмена');
                }
            }
        }
    });
})();
