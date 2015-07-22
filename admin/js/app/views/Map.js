(function() {
    'use strict';

    app.views.Map = Backbone.View.extend({

        ctx: undefined,
        CELL_WIDTH: 30,
        CELL_HEIGHT: 30,
        vicinity: undefined,
        cellsSprite: undefined,

        initialize: function() {
            this.ctx = this.$el.find('canvas').get(0).getContext('2d');

            this.vicinity = window.vicinity;
            this.cellsSprite = new Image;

            this.cellsSprite.src = window.siteUrl + '/img/world/cells.png';

            $(this.cellsSprite).load(function() {
                this._drawMap();
            }.bind(this));
        },

        events: {
            'mousemove canvas': function(e) {
                this._drawMap();
                this._drawHover(Math.floor(e.offsetX / this.CELL_WIDTH),
                                Math.floor(e.offsetY / this.CELL_HEIGHT));
            },

            'mouseover canvas': function(e) {
                this._drawMap();
                this._drawHover(Math.floor(e.offsetX / this.CELL_WIDTH),
                                Math.floor(e.offsetY / this.CELL_HEIGHT));
            },

            'mouseout canvas': function(e) {
                this._drawMap();
            }
        },

        _drawMap: function() {
            for (var i = 0; i < this.vicinity.length; i++) {
                for (var j = 0; j < this.vicinity[i].length; j++) {
                    this._drawCell(i, j);
                }
            }
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
