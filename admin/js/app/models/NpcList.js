(function() {
    'use strict';

    app.models.NpcList = Backbone.Collection.extend({

        model: app.models.Npc,

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

                        collection.each(function(item, i) {
                            item.attributes.index = i;
                        });

                        collection.trigger('sync');
                    });
                    break;
            }
        }
    });
})();
