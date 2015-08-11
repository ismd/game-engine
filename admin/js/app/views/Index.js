(function() {
    'use strict';

    app.views.Index = app.views.Index || {};

    app.views.Index.Index = Backbone.View.extend({

        initialize: function() {
            this.model.getInfo().then(function(info) {
                var content = Mustache.render($('#characters-list-template').html(), {
                    characters: info.characters
                });

                this.$el.find('.js-characters').html(content);
                this.$el.find('.js-characters-count').text(info.characters.length);
            }.bind(this));
        }
    });
})();
