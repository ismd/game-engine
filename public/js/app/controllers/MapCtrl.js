function MapCtrl($scope, $window, Map) {
    $scope.x = $window.x;
    $scope.y = $window.y;

    Map.init($scope.x, $scope.y);

    $scope.moveTop = function() {
        Map.move('top');
    };

    $scope.$on('move', function(e, x, y) {
        $scope.x = x;
        $scope.y = y;
    });
}

MapCtrl.$inject = ['$scope', '$window', 'Map'];
