'use strict';

function MapCtrl($scope, Map, Character) {
    var character = Character.getCharacter();

    $scope.map = {
        idMap: character.idMap,
        x: character.x,
        y: character.y
    };

    Map.init($scope.map.idMap, $scope.map.x, $scope.map.y);

    $scope.map.moveTop = function() {
        Map.move('top');
    };

    $scope.map.moveRight = function() {
        Map.move('right');
    };

    $scope.map.moveBottom = function() {
        Map.move('bottom');
    };

    $scope.map.moveLeft = function() {
        Map.move('left');
    };

    $scope.$on('move', function(e, x, y) {
        $scope.map.x = x;
        $scope.map.y = y;
    });
}

MapCtrl.$inject = ['$scope', 'Map', 'Character'];
