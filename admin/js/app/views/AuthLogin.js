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
                app.ws.send({
                    controller: 'User',
                    action: 'login',
                    args: {
                        username: this.model.get('login'),
                        password: this.model.get('password')
                    }
                }).then(function(data) {
                    // localStorage.setItem('user', JSON.stringify(data.user));

                    setCookie('user_id', data.user.id, {
                        path: '/'
                    });

                    setCookie('user_authKey', data.user.authKey, {
                        path: '/'
                    });

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
