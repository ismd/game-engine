'use strict';

function CellContentCtrl($scope, CellContent) {
    setInterval(function() {
        CellContent.updateCellContent($scope.content);
    }, 1000);

    $scope.selectedItem = undefined;

    $scope.content = {
        npcs: [],
        characters: [],
        mobs: []
    };

    $scope.selectItem = function(type, id) {
        $scope.selectedItem = {
            type: type,
            id: id
        };
    };

    $scope.$on('cell-content-update', function(e, data) {
        $scope.content = data;
    });
}

CellContentCtrl.$inject = ['$scope', 'CellContent'];
