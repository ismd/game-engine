(function() {
    'use strict';

    app.views.CanvasMap = Backbone.View.extend({

        singleSelectedCell: undefined,

        canvas: undefined,
        ctx: undefined,
        CELL_WIDTH: 30,
        CELL_HEIGHT: 30,
        vicinity: undefined,
        cellsSprite: undefined,
        filledCells: [],

        _hammerMoving: false,

        initialize: function(options) {
            this.singleSelectedCell = 'undefined' !== typeof options.singleSelectedCell ? options.singleSelectedCell : false;

            this.canvas = this.$el.find('canvas').get(0);
            this.ctx = this.canvas.getContext('2d');

            this.vicinity = window.vicinity;
            this.cellsSprite = new Image;

            $(this.cellsSprite).load(function() {
                this.render();
            }.bind(this));

            this.cellsSprite.src = window.siteUrl + '/img/world/cells.png';
            this.cellsSprite.setAttribute('crossOrigin', 'anonymous');

            var mc = new Hammer(this.$el.find('canvas').get(0));

            mc.get('pan').set({
                direction: Hammer.DIRECTION_ALL
            });

            mc.on('panmove', function(e) {
                if (this.singleSelectedCell) {
                    return;
                }

                this._hammerMoving = true;

                var x = Math.floor(e.srcEvent.offsetX / this.CELL_WIDTH),
                    y = Math.floor(e.srcEvent.offsetY / this.CELL_HEIGHT);

                var found = false;
                for (var i = 0; i < this.filledCells.length; i++) {
                    var cell = this.filledCells[i];

                    if (x === cell.x && y === cell.y) {
                        found = true;
                    }
                }

                if (!found) {
                    this.filledCells.push({
                        idLayout: 1,
                        x: x,
                        y: y
                    });
                }

                this.trigger('filledCellsUpdated', this.filledCells);
                this.render();

                setTimeout(function() {
                    this._hammerMoving = false;
                }.bind(this), 1000);
            }.bind(this));
        },

        events: {
            'click canvas': function(e) {
                if (this._hammerMoving) {
                    return;
                }

                if (this.singleSelectedCell) {
                    this.filledCells = [];
                }

                var x = Math.floor(e.offsetX / this.CELL_WIDTH),
                    y = Math.floor(e.offsetY / this.CELL_HEIGHT);

                for (var i = 0; i < this.filledCells.length; i++) {
                    var cell = this.filledCells[i];

                    if (x === cell.x && y === cell.y) {
                        this.filledCells.splice(i, 1);
                        this.trigger('filledCellsUpdated', this.filledCells);
                        this.render();
                        return;
                    }
                }

                this.filledCells.push({
                    idLayout: 1,
                    x: x,
                    y: y
                });

                this.trigger('filledCellsUpdated', this.filledCells);
                this.render();
            },

            'mousemove canvas': function(e) {
                if (this._hammerMoving) {
                    return;
                }

                if (e.which) {
                    return;
                }

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
            this.trigger('filledCellsUpdated', this.filledCells);
            this.render();
        },

        getFilledCells: function() {
            return this.filledCells;
        },

        setSize: function(width, height) {
            this.ctx.canvas.width = width * this.CELL_WIDTH;
            this.ctx.canvas.height = height * this.CELL_HEIGHT;

            if (height < this.vicinity.length) {
                this.vicinity = this.vicinity.slice(0, height);
            } else if (height > this.vicinity.length) {
                var currentHeight = this.vicinity.length;

                for (var i = 0; i < height - currentHeight; i++) {
                    var row = [];

                    for (var j = 0; j < this.vicinity[0].length; j++) {
                        row.push([0, 0]);
                    }

                    this.vicinity.push(row);
                }
            }

            if (width < this.vicinity[0].length) {
                for (var i = 0; i < this.vicinity.length; i++) {
                    this.vicinity[i] = this.vicinity[i].slice(0, width);
                }
            } else if (width > this.vicinity[0].length) {
                var currentWidth = this.vicinity[0].length;

                for (var i = 0; i < this.vicinity.length; i++) {
                    for (var j = 0; j < width - currentWidth; j++) {
                        this.vicinity[i].push([0, 0]);
                    }
                }
            }

            this.trigger('cellsUpdated', this.vicinity);
            this.render();
        },

        getDataUrl: function() {
            return this.canvas.toDataURL();
        },

        setCell: function(x, y, coords) {
            this.vicinity[y][x] = coords;
            this.trigger('cellsUpdated', this.vicinity);
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
