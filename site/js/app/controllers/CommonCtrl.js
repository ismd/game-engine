(function() {
    'use strict';

    window.mainModule.controller('CommonCtrl', ['$scope', 'Common', 'Stat', function($scope, Common, Stat) {

        $scope.redirect = function(url) {
            Common.redirect(url);
        };

        $scope.characterStat = function(stat) {
            return Stat.statName(stat);
        };

        $scope.characterArchetype = function(firstStat, stat) {
            return Stat.archetypeName(firstStat, stat);
        };

        $scope.$on('start-fight', function(e) {
            Common.redirect('/world/fight');
        });
    }]);
})();
