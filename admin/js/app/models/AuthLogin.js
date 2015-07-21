(function() {
    'use strict';

    app.models.Auth = app.models.Auth || {};

    app.models.Auth.Login = Backbone.Model.extend({

        validate: function(attrs, options) {
            if ('' === attrs.login) {
                return 'Введите логин';
            }

            if ('' === attrs.password) {
                return 'Введите пароль';
            }
        }
    });
})();
