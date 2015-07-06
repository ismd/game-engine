(function() {
    'use strict';

    window.mainModule.factory('Stat', [function() {
        var service = {};

        service.stats = ['Восприятие', 'Воля', 'Интеллект'];

        service.archetypes = [
            ['Наставник', 'Воин', 'Хранитель'],
            ['Странник', 'Стоик', 'Школяр'],
            ['Искатель', 'Вестник', 'Творец']
        ];

        service.statName = function(stat) {
            switch (stat) {
            case 0:
                return 'Восприятие';
                break;

            case 1:
                return 'Воля';
                break;

            case 2:
                return 'Интеллект';
                break;
            }

            return '-';
        };

        service.archetypeName = function(firstStat, stat) {
            return service.archetypes[firstStat][stat];
        };

        return service;
    }]);
})();
