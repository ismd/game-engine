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

require(['jquery', 'bootstrap', 'angular', 'app/auth', 'app/select_character', 'app/map'],
function($, bootstrap, angular, auth, select_character, map) {
    
});
