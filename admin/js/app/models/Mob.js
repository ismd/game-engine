(function() {
    'use strict';

    app.models.Mob = Backbone.Model.extend({

        sync: function(method, model) {
            switch (method) {
            case 'create':
                app.ws.send({
                    controller: 'AdminMob',
                    action: 'create',
                    args: this.attributes
                }).then(function() {
                    model.trigger('sync');
                });

                break;

            case 'update':
                app.ws.send({
                    controller: 'AdminMob',
                    action: 'update',
                    args: this.attributes
                }).then(function() {
                    model.trigger('sync');
                });

                break;
            }
        }
    });
})();
