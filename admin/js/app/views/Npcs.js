(function() {
    'use strict';

    app.views.Npcs = app.views.Npc || {};

    app.views.Npcs.Index = Backbone.View.extend({

        npcs: new app.models.NpcList,
        $activeNpc: undefined,
        newNpc: undefined,
        cell: undefined,

        initialize: function() {
            this.npcs.on('sync', function() {
                var content = Mustache.render($('#npc-list-template').html(), {
                    npcs: this.npcs.models
                });

                this.$el.find('.js-npc-list').html(content);
            }.bind(this));

            this.npcs.fetch();

            this.map = new app.views.CanvasMap({
                el: this.$el.find('.js-map'),
                singleSelectedCell: true
            });

            this.map.on('filledCellsUpdated', function(cells) {
                var html = Mustache.render($('#map-cells-template').html(), {
                    cells: cells
                });

                this.$el.find('.js-selected-cells').html(html);

                if (1 !== cells.length) {
                    alert('Ошибка с количеством выбранных клеток');
                    return;
                }

                this.cell = cells[0];
            }.bind(this));
        },

        events: {
            'click .js-npc': function(e) {
                var $target = $(e.target),
                    index = $target.data('index');

                this.$el.find('.js-npc').removeClass('active');
                $target.addClass('active');
                this.$activeNpc = $target;

                this._updateTemplate(index,
                    this.$el.find('#npc-info-template').html());

                var npc = this.npcs.at(index);
                this.map.fillCells([{
                    idLayout: npc.attributes.idLayout,
                    x: npc.attributes.x,
                    y: npc.attributes.y
                }]);
            },

            'click .js-add': function() {
                this.$activeNpc = undefined;
                this.$el.find('.js-npc').removeClass('active');

                this.newNpc = new app.models.Npc;

                var template = this.$el.find('#npc-edit-template').html(),
                    result = Mustache.render(template, {
                        npc: this.newNpc
                    });

                this.$el.find('.js-npc-info').html(result);
                this._initUploader(this.newNpc);

                this.newNpc.on('sync', function() {
                    this.npcs.fetch();
                }.bind(this));
            },

            'click .js-edit': function() {
                var index = this.$activeNpc.data('index'),
                    npc = this.npcs.at(index);

                this._updateTemplate(index,
                    this.$el.find('#npc-edit-template').html());

                this._initUploader(npc);
            },

            'click .js-back': function() {
                this._updateTemplate('undefined' !== typeof this.$activeNpc ? this.$activeNpc.data('index') : undefined,
                    this.$el.find('#npc-info-template').html());
            },

            'click .js-save': function() {
                var npc;

                if ('undefined' !== typeof this.$activeNpc) {
                    var index = this.$activeNpc.data('index');
                    npc = this.npcs.at(index);
                } else {
                    npc = this.newNpc;
                }

                if ('undefined' === typeof this.cell) {
                    alert('Не выбрана клетка');
                    return;
                }

                npc.attributes.idLayout = this.cell.idLayout;
                npc.attributes.x = this.cell.x;
                npc.attributes.y = this.cell.y;

                npc.set({
                    name: this.$el.find('[name="name"]').val(),
                    greeting: this.$el.find('[name="greeting"]').val()
                });

                npc.save();
            },

            'click .js-delete': function() {
                if (!confirm('Удалить NPC?')) {
                    return;
                }

                var index = this.$activeNpc.data('index'),
                    npc = this.npcs.at(index);

                npc.destroy({
                    success: function() {
                        this.$activeNpc = undefined;
                        this.$el.find('.js-npc-info').html('');
                        this.npcs.fetch();
                    }.bind(this)
                });
            }
        },

        _updateTemplate: function(index, template) {
            var $content = this.$el.find('.js-npc-info');

            if ('undefined' === typeof index) {
                $content.html('');
                return;
            }

            var result = Mustache.render(template, {
                npc: this.npcs.at(index)
            });

            $content.html(result);
        },

        _initUploader: function(npc) {
            this.$el.find('[name="image"]').fileupload({
                dataType: 'json',
                url: '/upload/npc',
                done: function (e, data) {
                    var result = data.result;

                    if ('ok' !== result.status) {
                        alert('Ошибка при загрузке файла');
                        return;
                    }

                    npc.set('image', result.image);

                    var $image = this.$el.find('.js-image'),
                        src = $image.attr('src'),
                        strIndex = src.indexOf('120x120_');

                    $image.attr('src',
                        src.substr(0, strIndex)
                        + '120x120_'
                        + result.image);
                }.bind(this)
            });
        }
    });
})();
