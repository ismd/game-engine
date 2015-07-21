(function() {
    'use strict';

    window.app = {};
    app.views = {};
    app.models = {};

    $(function () {
        app.ws = new app.models.Ws;

        app.router = new app.Router(window.location.pathname);
        app.router.call();
    });
})();
