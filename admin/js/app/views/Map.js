(function() {
    'use strict';

    app.views.Map = Backbone.View.extend({

        ctx: undefined,
        CELL_WIDTH: 30,
        CELL_HEIGHT: 30,
        vicinity: undefined,
        cellsSprite: undefined,
        filledCells: [],

        initialize: function() {
            this.ctx = this.$el.find('canvas').get(0).getContext('2d');

            this.vicinity = window.vicinity;
            this.cellsSprite = new Image;

            $(this.cellsSprite).load(function() {
                this.render();
            }.bind(this));

            this.cellsSprite.src = window.siteUrl + '/img/world/cells.png';
        },

        events: {
            'click canvas': function(e) {
                var x = Math.floor(e.offsetX / this.CELL_WIDTH),
                    y = Math.floor(e.offsetY / this.CELL_HEIGHT);

                for (var i = 0; i < this.filledCells.length; i++) {
                    var cell = this.filledCells[i];

                    if (x === cell.x && y === cell.y) {
                        this.filledCells.splice(i, 1);
                        this.trigger('cellsUpdated', this.filledCells);
                        this.render();
                        return;
                    }
                }

                this.filledCells.push({
                    idLayout: 1,
                    x: x,
                    y: y
                });

                this.trigger('cellsUpdated', this.filledCells);
                this.render();
            },

            'mousemove canvas': function(e) {
                this.render();
                this._drawHover(Math.floor(e.offsetX / this.CELL_WIDTH),
                                Math.floor(e.offsetY / this.CELL_HEIGHT));
            },

            'mouseover canvas': function(e) {
                this.render();
                this._drawHover(Math.floor(e.offsetX / this.CELL_WIDTH),
                                Math.floor(e.offsetY / this.CELL_HEIGHT));
            },

            'mouseout canvas': function(e) {
                this.render();
            }
        },

        fillCells: function(cells) {
            this.filledCells = cells;
            this.render();
        },

        render: function() {
            for (var i = 0; i < this.vicinity.length; i++) {
                for (var j = 0; j < this.vicinity[i].length; j++) {
                    this._drawCell(i, j);
                }
            }

            this.ctx.fillStyle = 'rgba(255, 0, 0, .5)';

            for (var i = 0; i < this.filledCells.length; i++) {
                var cell = this.filledCells[i];

                this.ctx.fillRect(cell.x * this.CELL_WIDTH,
                                  cell.y * this.CELL_HEIGHT, 30, 30);
            }

            var html = Mustache.render($('#map-cells-template').html(), {
                cells: this.filledCells
            });

            this.$el.find('.js-selected-cells').html(html);
            return this;
        },

        _drawCell: function(x, y) {
            this.ctx.drawImage(this.cellsSprite,
                               this.vicinity[x][y][0] * this.CELL_WIDTH,
                               this.vicinity[x][y][1] * this.CELL_HEIGHT,
                               this.CELL_WIDTH,
                               this.CELL_HEIGHT,
                               y * this.CELL_WIDTH,
                               x * this.CELL_HEIGHT,
                               this.CELL_WIDTH,
                               this.CELL_HEIGHT);
        },

        _drawHover: function(x, y) {
            this.ctx.fillStyle = 'rgba(255, 255, 255, .5)';
            this.ctx.fillRect(x * this.CELL_WIDTH, y * this.CELL_HEIGHT, 30, 30);
        }
    });
})();
