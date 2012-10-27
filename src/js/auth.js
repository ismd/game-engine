$(document).ready(function() {
    var name       = $('div#auth-form input#login'),
        password   = $('div#auth-form input#password')

    $('a#auth-button').click(function(e) {
        e.preventDefault();
        $('#auth-form').dialog('open')
    });

    $('a#select-character').click(function(e) {
        e.preventDefault();
        getUserCharacters();
    });

    $('div#auth-form').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        draggable: false,
        buttons: {
            'Войти': function() {
                auth(name.val(), password.val());
            },
            'Отмена': function() {
                $(this).dialog('close');
            }
        }
    });

    $('div#characters-list').dialog({
        autoOpen: false,
        modal: true,
        resizable: false
    });
});

/**
 * Пытаемся залогиниться путём отправки post-запроса
 * При удачной аутентификации вызывается getUserCharacters()
 */
function auth(login, password) {
    $.ajax({
        url: '/auth/login',
        type: 'post',
        data: {
            'login': login,
            'password': password
        },
        success: function(data) {
            if (data == 'ok') {
                getUserCharacters();
            } else {
                alert('Не удалось войти')
            }
        }
    });
}

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
        type: 'get',
        data: 'id=' + id,
        success: function(data) {
            if (data == 'ok') {
                window.location.replace('/world')
            } else {
                alert('Не удалось войти')
            }
        }
    })
}
