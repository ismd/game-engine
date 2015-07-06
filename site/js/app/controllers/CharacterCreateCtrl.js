(function() {
    'use strict';

    window.mainModule.controller('CharacterCreateCtrl', ['$scope', 'FileUploader', 'CharacterCreate', 'Character', 'Stat', function($scope, FileUploader, CharacterCreate, Character, Stat) {
        $scope.errors = {
            name: false,
            image: false
        };

        $scope.newCharacter = {
            name: '',
            biography: '',
            stats: [0, 1, 2]
        };

        var stats      = Stat.stats,
            archetypes = Stat.archetypes;

        // Текущие выбранные характеристики и архетипы по порядку
        $scope.stats      = [stats[0], stats[1], stats[2]];
        $scope.archetypes = [archetypes[0][0], archetypes[1][1], archetypes[2][2]];

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

        $scope.swap = function(top) {
            var tmpStat;

            if (top) {
                tmpStat = $scope.stats[0];
                $scope.stats[0] = $scope.stats[1];
                $scope.stats[1] = tmpStat;
            } else {
                tmpStat = $scope.stats[1];
                $scope.stats[1] = $scope.stats[2];
                $scope.stats[2] = tmpStat;
            }

            setArchetype(0);
            setArchetype(1);
            setArchetype(2);

            function setArchetype(i) {
                switch ($scope.stats[i]) {
                case stats[0]:
                    $scope.archetypes[i] = archetypes[i][0];
                    $scope.newCharacter.stats[i] = 0;
                    break;

                case stats[1]:
                    $scope.archetypes[i] = archetypes[i][1];
                    $scope.newCharacter.stats[i] = 1;
                    break;

                case stats[2]:
                    $scope.archetypes[i] = archetypes[i][2];
                    $scope.newCharacter.stats[i] = 2;
                    break;
                }
            }
        };
    }]);
})();
