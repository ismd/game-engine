function CharacterCtrl($scope, $window) {
    $scope.character = $window.character;

    $scope.$on('characterChosen', function(e, character) {
        $scope.character = character;
    });
}

CharacterCtrl.$inject = ['$scope', '$window'];
