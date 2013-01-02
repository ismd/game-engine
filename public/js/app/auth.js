$(document).ready(function() {
    var name     = $('div#auth-form input#login'),
        password = $('div#auth-form input#password')

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
