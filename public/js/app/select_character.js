/**
 * Получает список персонажей пользователя, выводит окошко с выбором персонажа
 */
function getUserCharacters() {
    $.getJSON('/user/characters', function(data) {
        // Если у пользователя ещё нет персонажей, то перенаправляем на страницу создания персонажа
        if (data.length == 0) {
            window.location.replace('/character/create');
            return;
        }

        $('ul#characters-list li').remove()

        $.each(data, function(key, val) {
            var link = $('<a/>', {
                id: val.id,
                'class': 'character-item',
                href: '#',
                text: val.name + ' (' + val.level + ' уровень)'
            }).click(function() {
                setCharacter(this.id);
            });

            var item = $('<li/>', {
                id: val.id
            }).append(link);

            $('ul#characters-list').append(item);
        });

        $('div#auth-form').dialog('close');
        $('div#characters-list').dialog('open');
    });
}

/**
 * Устанавливает текущего персонажа для игры
 * Если удалось, то идёт перенаправление на /world
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
                window.location.replace('/world')
            } else {
                alert('Не удалось войти')
            }
        }
    })
}
