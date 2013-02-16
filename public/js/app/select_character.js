define(['jquery'], function($) {

    /**
     * Инициализируем модуль
     * При клике по кнопке смены персонажа загружаем их список
     * Окно показывается автоматически с помощью bootstrap api (data-toggle, data-target)
     */
    $('a#select-character-open').click(function(e) {
        e.preventDefault();
        fillUserCharacters();
    });

    return {
        'showUserCharacters': showUserCharacters
    };

    /**
     * Показывает окно со списком персонажей
     */
    function showUserCharacters() {
        fillUserCharacters();
        $('div#select-character').modal();
    }

    /**
     * Загружает список персонажей пользователя
     */
    function fillUserCharacters() {
        $.ajax({
            url: '/p/user/characters',
            type: 'get',
            success: function(data) {
                updateUserCharactersList(eval(data));
            }
        });
    }

    /**
     * Обновляет список персонажей пользователя
     * Перенаправляет на страницу создания персонажа, если ни одного нет
     */
    function updateUserCharactersList(characters) {
        var charactersList = $('div#select-character ul#characters-list');

        // Если у пользователя ещё нет персонажей, то перенаправляем на страницу создания персонажа
        if (characters.length == 0) {
            window.location.replace('/p/character/create');
            return;
        }

        // Очищаем список
        charactersList.empty();
        
        // Наполняем список
        $.each(characters, function(i, character) {
            // Создаём ссылку
            var link = $('<a/>', {
                id: character.id,
                href: '#',
                text: character.name + ' (' + character.level + ' уровень)'
            }).click(function(e) {
                e.preventDefault();

                // При клике выбираем персонажа
                setCharacter(this.id);
            });

            var item = $('<li/>', {
                id: character.id
            }).append(link);

            // Добавляем персонажа в список
            charactersList.append(item);
        });
    }

    /**
     * Устанавливает текущего персонажа для игры
     * Если удалось, то перенаправляет на /world
     */
    function setCharacter(id) {
        $.ajax({
            url: '/p/character/set',
            type: 'post',
            data: {
                'id': id
            },
            success: function(data) {
                if (data == 'ok') {
                    window.location.replace('/p/world');
                } else {
                    alert('Не удалось выбрать персонажа');
                }
            }
        });
    }
});