(function() {
    'use strict';

    app.views.Mobs = app.views.Mobs || {};

    app.views.Mobs.Index = Backbone.View.extend({

        mobs: new app.models.MobList,
        $activeMob: undefined,
        newMob: undefined,

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

            'click .js-add': function() {
                this.$activeMob = undefined;

                var template = this.$el.find('#mob-add-template').html(),
                    result = Mustache.render(template);

                this.$el.find('.js-mob-info').html(result);

                this.newMob = new app.models.Mob;
                this._initUploader(this.newMob);

                this.newMob.on('sync', function() {
                    this.mobs.fetch();
                }.bind(this));
            },

            'click .js-edit': function() {
                this._updateTemplate(this.$activeMob.data('index'),
                                     this.$el.find('#mob-edit-template').html());

                var index = this.$activeMob.data('index'),
                    mob = this.mobs.at(index);

                this._initUploader(mob);
            },

            'click .js-delete': function() {
                var index = this.$activeMob.data('index'),
                    mob = this.mobs.at(index);

                mob.destroy({
                    success: function() {
                        this.$activeMob = undefined;
                        this.$el.find('.js-mob-info').html('');
                        this.mobs.fetch();
                    }.bind(this)
                });
            },

            'click .js-back': function() {
                this._updateTemplate('undefined' !== typeof this.$activeMob ? this.$activeMob.data('index') : undefined,
                                     this.$el.find('#mob-info-template').html());
            },

            'click .js-save': function() {
                var mob;

                if ('undefined' !== typeof this.$activeMob) {
                    var index = this.$activeMob.data('index');
                    mob = this.mobs.at(index);
                } else {
                    mob = this.newMob;
                }

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
            var $content = this.$el.find('.js-mob-info');

            if ('undefined' === typeof index) {
                $content.html('');
                return;
            }

            var result = Mustache.render(template, {
                mob: this.mobs.at(index)
            });

            $content.html(result);
        },

        _initUploader: function(mob) {
            this.$el.find('[name="image"]').fileupload({
                dataType: 'json',
                url: '/upload/mob',
                done: function (e, data) {
                    var result = data.result;

                    if ('ok' !== result.status) {
                        alert('Ошибка при загрузке файла');
                        return;
                    }

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
        }
    });
})();
