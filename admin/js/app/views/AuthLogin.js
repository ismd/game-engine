(function() {
    'use strict';

    app.views.Auth = app.views.Auth || {};

    app.views.Auth.Login = Backbone.View.extend({

        initialize: function() {
            this.$errorMessage = $('.js-error-message');
            this._updateModel();
        },

        events: {
            'submit form': 'submit'
        },

        submit: function(e) {
            e.preventDefault();
            this._updateModel();

            if (!this.model.isValid()) {
                this.$errorMessage.text(this.model.validationError);
            } else {
                var userModel = new app.models.User;

                userModel.auth(
                    this.model.get('login'),
                    this.model.get('password')
                ).then(function(data) {
                    window.location.href = '/';
                }, function(error) {
                    this.$errorMessage.text(error);
                }.bind(this));
            }
        },

        _updateModel: function() {
            this.model.set({
                login: $('input[name="login"]').val(),
                password: $('input[name="password"]').val()
            });
        }
    });
})();
