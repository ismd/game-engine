'use strict';

function WorldCtrl(World) {
    setInterval(function() {
        World.updateCellContent();
    }, 1000);
}

WorldCtrl.$inject = ['World'];
