(function() {
    'use strict';

    window.mainModule.controller('FightCtrl', ['$scope', 'Fight',
                                               function($scope, Fight) {

        $scope.steps = [];
        $scope.enemy = {};

        Fight.getFightInfo().then(function(data) {
            parseInitiator(data.initiator);
            parseEnemy(data.enemy);

            for (var i = 0; i < data.steps.length; i++) {
                parseStep(data.steps[i]);
            }
        });

        $scope.$on('fight-step', function(e, data) {
            parseInitiator(data.initiator);
            parseEnemy(data.enemy);
            parseStep(data.step);
        });

        function parseInitiator(initiator) {
        }

        function parseEnemy(enemy) {
            if ('undefined' !== typeof enemy.mobInfo) {
                $.extend(enemy, enemy.mobInfo);
            }

            $scope.enemy = enemy;
        }

        function parseStep(step) {
            $scope.steps = $scope.steps.concat(step);
            $scope.$apply();
        }
    }]);
})();
