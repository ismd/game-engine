(function() {
    'use strict';

    window.mainModule.controller('CharacterCreateCtrl', ['$scope', 'FileUploader', 'CharacterCreate', 'Character', function($scope, FileUploader, CharacterCreate, Character) {
        $scope.errors = {
            name: false,
            image: false
        };

        $scope.newCharacter = {
            name: '',
            biography: '',
            strength: 3,
            speed: 3,
            endurance: 3,
            perception: 3,
            intelligence: 3,
            will: 3
        };

        CharacterCreate.focus();

        $scope.uploader = new FileUploader({
            url: '/api/upload/avatar',
            filters: [{
                name: 'type',
                fn: function(item) {
                    if ('image/jpeg' !== item.type && 'image/png' !== item.type && 'image/gif' !== item.type) {
                        return false;
                    }

                    return true;
                }
            }]});

        $scope.create = function() {
            if (!checkForm()) {
                return;
            }

            $scope.uploader.uploadAll();

            function checkForm() {
                if (!$scope.newCharacter.name) {
                    $scope.errors.name = true;
                    return false;
                } else {
                    $scope.errors.name = false;
                }

                if (undefined === $scope.fileUploadError || $scope.fileUploadError) {
                    $scope.errors.image = true;
                    return false;
                } else {
                    $scope.errors.image = false;
                }

                return true;
            }
        };

        $scope.uploader.onCompleteItem = function(item, response, status, headers) {
            if ('ok' !== response.status) {
                return;
            }

            $scope.newCharacter.image = response.image;

            CharacterCreate.create($scope.newCharacter).then(function(character) {
                Character.set(character.id);
            }, function(message) {
                $scope.message = message;
            });
        };

        $scope.uploader.onAfterAddingFile = function() {
            $scope.fileUploadError = false;
        };

        $scope.uploader.onWhenAddingFileFailed = function() {
            $scope.fileUploadError = true;
        };
    }]);
})();
