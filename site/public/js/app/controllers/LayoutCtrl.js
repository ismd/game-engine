'use strict';

function LayoutCtrl($scope, Layout, Character) {
    return;
    var character = Character.getCharacter();

    $scope.layout = {
        idLayout: character.idLayout,
        x: character.x,
        y: character.y
    };

    //Layout.init($scope.layout.idLayout, $scope.layout.x, $scope.layout.y);

    $scope.layout.moveTop = function() {
        Layout.move('top');
    };

    $scope.layout.moveRight = function() {
        Layout.move('right');
    };

    $scope.layout.moveBottom = function() {
        Layout.move('bottom');
    };

    $scope.layout.moveLeft = function() {
        Layout.move('left');
    };

    $scope.$on('move', function(e, x, y) {
        $scope.layout.x = x;
        $scope.layout.y = y;
    });
}

LayoutCtrl.$inject = ['$scope', 'Layout', 'Character'];
