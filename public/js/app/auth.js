define(['jquery', 'app/select_character'], function($, select_character) {
    var username = $('div#auth-form input#username'),
        password = $('div#auth-form input#password');
    
    $('a#auth-button-login').click(function(e) {
        e.preventDefault();

        var authButton = $('a#auth-button-login');

        // Блокируем кнопку входа
        authButton.addClass('disabled');

        // Пытаемся залогиниться
        var logged = auth(username.val(), password.val());

        if (logged == true) {
            $('div#auth-form').modal('hide');
            select_character.showCharacters();
        } else {
            authButton.removeClass('disabled');
            authFailed();
        }
    });

    /**
     * Пытается залогиниться путём отправки post-запроса
     * @return bool
     */
    function auth(username, password) {
        var logged = false;

        $.ajax({
            url: '/auth/login',
            type: 'post',
            data: {
                'username': username,
                'password': password
            },
            async: false,
            success: function(data) {
                if (data == 'ok') {
                    logged = true;
                }
            }
        });

        return logged;
    }

    /**
     * Вызывается при неудачной попытке входа
     */
    function authFailed() {
        alert('Не удалось войти');
    }
});
