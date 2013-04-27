'use strict';

function CellContentCtrl($scope) {
    $scope.selectedItem = undefined;

    $scope.content = [{
        type: 'player',
        id: 1,
        image: '/img/world/hero.png',
        name: 'ismd123'
    }, {
        type: 'mob',
        id: 1,
        image: '/img/world/mobs/cat.png',
        name: 'Кот'
    }, {
        type: 'mob',
        id: 2,
        image: '/img/world/mobs/dog.png',
        name: 'Собака'
    }, {
        type: 'mob',
        id: 3,
        image: '/img/world/mobs/vasya.png',
        name: 'Кот Вася'
    }, {
        type: 'npc',
        id: 1,
        image: '/img/world/npcs/king.png',
        name: 'Король'
    }];

    $scope.selectItem = function(type, id) {
        $scope.selectedItem = {
            type: type,
            id: id
        };
    };
}

CellContentCtrl.$inject = ['$scope'];
