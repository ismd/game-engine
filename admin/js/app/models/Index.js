(function() {
    'use strict';

    app.models.Index = Backbone.Model.extend({

        getInfo: function(callback) {
            var defer = Q.defer();

            app.ws.send({
                controller: 'AdminInfo',
                action: 'getInfo'
            }).then(function(data) {
                defer.resolve(data);
            }.bind(this));

            return defer.promise;
        }
    });
})();
