(function() {
    'use strict';

    app.Router = Backbone.Model.extend({

        initialize: function(path) {
            this.path = path;
        },

        call: function() {
            var url     = parse(this.path),
                view    = app.views,
                model   = app.models,
                noModel = false;

            for (var i = 0; i < url.length; i++) {
                var urlPart = url[i].capitalizeFirstLetter();

                if ('undefined' === typeof view[urlPart]) {
                    if (1 === url.length && '' === urlPart) {
                        // Главная страница
                        new app.views.Index.Index({
                            el: $('body'),
                            model: 'undefined' !== typeof app.models.Index ? new app.models.Index : undefined
                        });

                        return true;
                    }

                    return false;
                }

                view = view[urlPart];

                if (noModel || 'undefined' === typeof model[urlPart]) {
                    noModel = true;
                    continue;
                }

                model = model[urlPart];
            }

            if (1 === url.length) {
                view = view['Index'];
            }

            new view({
                el: $('body'),
                model: noModel ? undefined : new model
            });

            return true;

            function parse(path) {
                return trim(path, '/').split('/');
            }
        }
    });
})();
