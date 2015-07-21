(function() {
    'use strict';

    app.views.Mobs = app.views.Mobs || {};

    app.views.Mobs.Index = Backbone.View.extend({

        mobs: new app.models.MobList,

        initialize: function() {
            this.mobs.on('sync', function() {
                for (var i = 0; i < this.mobs.length; i++) {
                    this.mobs.at(i).set('index', i);
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

                var template = this.$el.find('#mob-info-template').html(),
                    result = Mustache.render(template, {
                        mob: this.mobs.at(index)
                    });

                this.$el.find('.js-mob-info').html(result);
            }
        }
    });
})();
