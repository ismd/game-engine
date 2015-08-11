(function() {
    'use strict';

    app.models.Npc = Backbone.Collection.extend({

        sync: function(method, collection) {
            switch (method) {
                case 'read':
                    app.ws.send({
                        controller: 'AdminNpc',
                        action: 'readAll'
                    }).then(function(data) {
                        collection.add(_.sortBy(data.npcs, function(npc) {
                            return npc.name;
                        }));

                        collection.trigger('sync');
                    });
                    break;
            }
        }
    });
})();
