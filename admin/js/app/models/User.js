(function() {
    'use strict';

    app.models.User = Backbone.Model.extend({

        auth: function(login, password) {
            var defer = Q.defer();

            app.ws.send({
                controller: 'User',
                action: 'login',
                args: {
                    username: login,
                    password: password,
                    admin: true
                }
            }).then(function(data) {
                setCookie('user_id', data.user.id, {
                    path: '/'
                });

                setCookie('user_authKey', data.user.authKey, {
                    path: '/'
                });

                defer.resolve(data);
            }, function(error) {
                defer.reject(error);
            });

            return defer.promise;
        },

        authByKey: function(id, authKey) {
            var defer = Q.defer();

            app.ws.send({
                controller: 'User',
                action: 'loginByAuthKey',
                args: {
                    id: id,
                    authKey: authKey,
                    admin: true
                }
            }).then(function(data) {
                setCookie('user_id', data.user.id, {
                    path: '/'
                });

                setCookie('user_authKey', data.user.authKey, {
                    path: '/'
                });

                defer.resolve(data);
            }, function(error) {
                defer.reject(error);
            });

            return defer.promise;
        }
    });
})();
