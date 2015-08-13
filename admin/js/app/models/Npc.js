(function() {
    'use strict';

    app.models.Npc = Backbone.Model.extend({

        sync: function(method, model, options) {
            switch (method) {
            case 'create':
                app.ws.send({
                    controller: 'AdminNpc',
                    action: 'create',
                    args: this.attributes
                }).then(function() {
                    model.trigger('sync');
                }, function(message) {
                    alert(message);
                });

                break;

            case 'update':
                app.ws.send({
                    controller: 'AdminNpc',
                    action: 'update',
                    args: this.attributes
                }).then(function() {
                    model.trigger('sync');
                }, function(message) {
                    alert(message);
                });

                break;

            case 'delete':
                app.ws.send({
                    controller: 'AdminNpc',
                    action: 'delete',
                    args: this.attributes
                }).then(function() {
                    options.success();
                }, function() {
                    options.error();
                });

                break;
            }
        }
    });
})();
