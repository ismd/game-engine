'use strict';

angular.module('worldService', []).factory('World', function($rootScope, $http) {
    return {
        'updateCellContent': function() {
            $http.post('/api/map/cell').success(function(data) {
                $rootScope.$broadcast('cell-content', data);
            });
        }
    };
});
