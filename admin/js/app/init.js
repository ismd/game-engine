(function() {
    'use strict';

    window.app = {};
    app.views = {};
    app.models = {};

    $(function () {
        app.ws = new app.models.Ws;

        var userModel = new app.models.User;
        userModel.authByKey(getCookie('user_id'), getCookie('user_authKey'));

        app.router = new app.Router(window.location.pathname);
        app.router.call();
    });
})();
