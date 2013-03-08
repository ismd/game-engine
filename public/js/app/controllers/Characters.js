function CharactersCtrl($scope, $http) {
    var selectCharacterForm = $('div#select-character');
    var loading             = selectCharacterForm.find('img.loading');

    $scope.$on('showCharactersList', function() {
        selectCharacterForm.modal();
        $scope.loadCharacters();
    });

    $scope.loadCharacters = function() {
        $http.get('/api/user/characters').success(function(data) {
            loading.hide();
            $scope.characters = data;
        }).error(function() {
            alert('Не удалось обратиться к серверу');
        });
    }
}

CharactersCtrl.$inject = ['$scope', '$http'];
