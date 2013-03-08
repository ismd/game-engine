function CharacterCtrl($scope) {
    $scope.$on('characterChosen', function(e, character) {
        $scope.character = character;
    });
}

CharacterCtrl.$inject = ['$scope'];
