require.config({
    baseUrl: '/js/lib',
    paths: {
        app: '/js/app'
    },
    shim: {
        'bootstrap': {
            deps: ['jquery']
        }
    }
});

require(['jquery', 'bootstrap', 'app/auth', 'app/select_character', 'app/map'],
function($, bootstrap, auth, select_character, map) {
    
});
