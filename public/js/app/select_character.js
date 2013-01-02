define(['jquery'], function($) {
    $('a#select-character').click(function(e) {
        e.preventDefault();
        showCharacters();
    });

    return {
        'showCharacters': showCharacters
    };

    /**
     * Показывает окно для выбора персонажа
     */
    function showCharacters() {
        var characters     = getUserCharacters();
        var charactersList = $('div#select-character ul#characters-list');

        // Если у пользователя ещё нет персонажей, то перенаправляем на страницу создания персонажа
        if (characters.length == 0) {
            window.location.replace('/character/create');
            return;
        }

        // Очищаем список
        charactersList.text('');
        
        // Наполняем список
        $.each(characters, function(i, character) {
            var link = $('<a/>', {
                id: character.id,
                href: '#',
                text: character.name + ' (' + character.level + ' уровень)'
            }).click(function() {
                setCharacter(this.id);
            });

            var item = $('<li/>', {
                id: character.id
            }).append(link);

            charactersList.append(item);
        });

        $('div#select-character').modal();
    }

    /**
     * Получает список персонажей пользователя, показывает окно с выбором персонажа
     * @return character[]
     */
    function getUserCharacters() {
        var characters;

        $.ajax({
            url: '/user/characters',
            type: 'get',
            async: false,
            success: function(data) {
                characters = eval(data);
            }
        });

        return characters;
    }

    /**
     * Устанавливает текущего персонажа для игры
     * Если удалось, то перенаправляет на /world
     */
    function setCharacter(id) {
        $.ajax({
            url: '/character/set',
            type: 'post',
            data: {
                'id': id
            },
            success: function(data) {
                if (data == 'ok') {
                    window.location.replace('/world');
                } else {
                    alert('Не удалось выбрать персонажа');
                }
            }
        });
    }
});