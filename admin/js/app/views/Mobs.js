(function() {
    'use strict';

    app.views.Mobs = app.views.Mobs || {};

    app.views.Mobs.Index = Backbone.View.extend({

        mobs: new app.models.MobList,
        $activeMob: undefined,

        initialize: function() {
            this.mobs.on('sync', function() {
                for (var i = 0; i < this.mobs.length; i++) {
                    var mob = this.mobs.at(i);

                    mob.set('index', i);
                    mob.on('sync', function() {
                        this._updateTemplate(this.$activeMob.data('index'),
                                             this.$el.find('#mob-info-template').html());
                    }.bind(this));
                }

                this.render();
            }.bind(this));

            this.mobs.fetch();
        },

        render: function() {
            var template = this.$el.find('#mobs-template').html(),
                result = Mustache.render(template, {
                    mobs: this.mobs.models
                });

            this.$el.find('.js-mobs-list').html(result);
            return this;
        },

        events: {
            'click .js-mob': function(e) {
                var $target = $(e.target),
                    index = $target.data('index');

                this.$el.find('.js-mob').removeClass('active');
                $target.addClass('active');
                this.$activeMob = $target;

                this._updateTemplate(index,
                                     this.$el.find('#mob-info-template').html());
            },

            'click .js-edit': function() {
                this._updateTemplate(this.$activeMob.data('index'),
                                     this.$el.find('#mob-edit-template').html());

                this.$el.find('[name="image"]').fileupload({
                    dataType: 'json',
                    url: '/upload/mob',
                    done: function (e, data) {
                        var result = data.result;

                        if ('ok' !== result.status) {
                            alert('Ошибка при загрузке файла');
                            return;
                        }

                        var index = this.$activeMob.data('index'),
                            mob = this.mobs.at(index);

                        mob.set('image', result.image);

                        var $image = this.$el.find('.js-image'),
                            src = $image.attr('src'),
                            strIndex = src.indexOf('120x120_');

                        $image.attr('src',
                                    src.substr(0, strIndex)
                                    + '120x120_'
                                    + result.image);
                    }.bind(this)
                });
            },

            'click .js-back': function() {
                this._updateTemplate(this.$activeMob.data('index'),
                                     this.$el.find('#mob-info-template').html());
            },

            'click .js-save': function() {
                var index = this.$activeMob.data('index'),
                    mob = this.mobs.at(index);

                mob.set({
                    name: this.$el.find('[name="name"]').val(),
                    level: this.$el.find('[name="level"]').val(),
                    minDamage: this.$el.find('[name="minDamage"]').val(),
                    maxDamage: this.$el.find('[name="maxDamage"]').val(),
                    maxHp: this.$el.find('[name="maxHp"]').val(),
                    experience: this.$el.find('[name="experience"]').val(),
                    maxInWorld: this.$el.find('[name="maxInWorld"]').val()
                });

                mob.save();
            }
        },

        _updateTemplate: function(index, template) {
            var result = Mustache.render(template, {
                mob: this.mobs.at(index)
            });

            this.$el.find('.js-mob-info').html(result);
        }
    });
})();
