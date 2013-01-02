require.config({
    baseUrl: 'js/lib',
    paths: {
        app: '../app'
    },
    shim: {
        'bootstrap': {
            deps: ['jquery']
        }
    }
});

require(['jquery', 'bootstrap', 'app/auth', 'app/select_character'],
function($, bootstrap, auth, select_character) {
    
});
