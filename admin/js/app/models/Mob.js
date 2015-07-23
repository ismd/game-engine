(function() {
    'use strict';

    app.models.Mob = Backbone.Model.extend({

        sync: function(method, model, options) {
            switch (method) {
            case 'create':
                app.ws.send({
                    controller: 'AdminMob',
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
                    controller: 'AdminMob',
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
                    controller: 'AdminMob',
                    action: 'delete',
                    args: this.attributes
                }).then(function() {
                    options.success();
                }, function() {
                    options.error();
                });

                break;
            }
        },

        getAvailableCells: function(callback) {
            app.ws.send({
                controller: 'AdminMob',
                action: 'getAvailableCells',
                args: this.attributes
            }).then(function(data) {
                this.attributes.availableCells = data.cells;
                callback(data);
            }.bind(this));
        },

        saveAvailableCells: function(callback) {
            app.ws.send({
                controller: 'AdminMob',
                action: 'setAvailableCells',
                args: this.attributes
            }).then(function(data) {
                callback(data);
            }, function(message) {
                alert('Ошибка: ' + message);
            });
        }
    });
})();
