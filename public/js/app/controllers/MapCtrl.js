function MapCtrl($scope, Map, Character) {
    var character = Character.getCharacter();

    $scope.idMap = character.idMap;
    $scope.x     = character.x;
    $scope.y     = character.y;

    Map.init($scope.idMap, $scope.x, $scope.y);

    $scope.moveTop = function() {
        Map.move('top');
    };

    $scope.moveRight = function() {
        Map.move('right');
    };

    $scope.moveBottom = function() {
        Map.move('bottom');
    };

    $scope.moveLeft = function() {
        Map.move('left');
    };

    $scope.$on('move', function(e, x, y) {
        $scope.x = x;
        $scope.y = y;
    });
}

MapCtrl.$inject = ['$scope', 'Map', 'Character'];
