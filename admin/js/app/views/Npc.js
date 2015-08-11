(function() {
    'use strict';

    app.views.Npc = app.views.Npc || {};

    app.views.Npc.Index = Backbone.View.extend({

        initialize: function() {
            this.model.on('sync', function() {
                var content = Mustache.render($('#npc-list-template').html(), {
                    npcs: this.model.models
                });

                this.$el.find('.js-npc-list').html(content);
            }.bind(this));

            this.model.fetch();
        }
    });
})();
