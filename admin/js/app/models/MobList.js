(function() {
    'use strict';

    app.models.MobList = Backbone.Collection.extend({

        model: app.models.Mob,

        sync: function(method, collection) {
            switch (method) {
            case 'read':
                app.ws.send({
                    controller: 'AdminMob',
                    action: 'readAll'
                }).then(function(data) {
                    collection.add(_.sortBy(data.mobs, function(mob) {
                        return mob.name;
                    }));

                    collection.trigger('sync');
                });
                break;
            }
        }
    });
})();
