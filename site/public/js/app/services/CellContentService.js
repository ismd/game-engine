'use strict';

angular.module('cellContentService', []).factory('CellContent', function($rootScope, $http) {
    var service = {};

    service.updateCellContent = function(content) {
        $http.post('/api/layout/cell').success(function(data) {
            var contentChanged = false;

            angular.forEach(content.npcs, function(item, i) {
                var found = false;

                angular.forEach(data.npcs, function(value) {
                    if (value.id === item.id) {
                        found = true;
                    }
                });

                if (!found) {
                    contentChanged = true;
                }
            });

            if (contentChanged) {
                content = data;
                $rootScope.$broadcast('cell-content-update', data);
                return;
            }

            angular.forEach(content.characters, function(item, i) {
                var found = false;

                angular.forEach(data.characters, function(value) {
                    if (value.id === item.id) {
                        found = true;
                    }
                });

                if (!found) {
                    contentChanged = true;
                }
            });

            if (contentChanged) {
                content = data;
                $rootScope.$broadcast('cell-content-update', data);
                return;
            }

            angular.forEach(content.mobs, function(item, i) {
                var found = false;

                angular.forEach(data.mobs, function(value) {
                    if (value.id === item.id) {
                        found = true;
                    }
                });

                if (!found) {
                    contentChanged = true;
                }
            });

            if (contentChanged) {
                content = data;
                $rootScope.$broadcast('cell-content-update', data);
                return;
            }

            angular.forEach(data.npcs, function(item) {
                var found = false;

                angular.forEach(content.npcs, function(value) {
                    if (value.id === item.id) {
                        found = true;
                    }
                });

                if (!found) {
                    contentChanged = true;
                }
            });

            if (contentChanged) {
                content = data;
                $rootScope.$broadcast('cell-content-update', data);
                return;
            }

            angular.forEach(data.characters, function(item) {
                var found = false;

                angular.forEach(content.characters, function(value) {
                    if (value.id === item.id) {
                        found = true;
                    }
                });

                if (!found) {
                    contentChanged = true;
                }
            });

            if (contentChanged) {
                content = data;
                $rootScope.$broadcast('cell-content-update', data);
                return;
            }

            angular.forEach(data.mobs, function(item) {
                var found = false;

                angular.forEach(content.mobs, function(value) {
                    if (value.id === item.id) {
                        found = true;
                    }
                });

                if (!found) {
                    contentChanged = true;
                }
            });

            if (contentChanged) {
                content = data;
                $rootScope.$broadcast('cell-content-update', data);
                return;
            }
        });
    };

    return service;
});
